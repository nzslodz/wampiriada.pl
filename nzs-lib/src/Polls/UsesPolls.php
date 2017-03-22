<?php namespace NZS\Core\Polls;

use App\Http\Requests;
use Illuminate\Http\Request;
use NZS\Core\Polls\Poll;
use NZS\Core\Person;
use NZS\Core\Polls\Answer;
use NZS\Core\Polls\CookieResolver;
use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Exceptions\CannotResolveInterface;
use NZS\Core\Contracts\PollUserFinder;
use NZS\Core\Contracts\PollFormRequest;
use NZS\Core\Contracts\PollFlow;
use NZS\Core\Contracts\PollProxy;
use NZS\Core\Contracts\PollAnswerIndexer;
use NZS\Core\Contracts\PollAnswerMailer;
use Auth;
use RuntimeException;
use Cookie;
use DB;

trait UsesPolls {
    protected function canPollBeAnswered(Request $request, PollProxy $poll_proxy, Person $user=null) {
        $poll = $poll_proxy->getPoll();

        if(!$poll->getPollClass()->allowMultipleResponses()) {
            if($user && Answer::whereUserId($user->id)->wherePollId($poll->id)->first()) {
                return false;
            }

            if($request->cookie("poll:{$proxy->poll->key}") == 'answered') {
                return false;
            }
        }

        return true;
    }

    protected function determineUser(Request $request, PollProxy $poll_proxy, $context) {
        $poll = $poll_proxy->getPoll();

        if(!$poll->getPollClass()->enableTracking()) {
            return null;
        }

        if(Auth::check()) {
            return Auth::user()->person;
        }

        if($request->input('m') && $context == 'display') {
            $user = Person::whereCampaignToken($request->input('m'))->first();

            if($user) {
                return $user;
            }
        }

        if($request->input('user_id') && $context == 'save') {
            $user = Person::find('user_id');

            if($user) {
                return $user;
            }
        }

        // match email when saving or when it's allowed to be passed as query parameter
        if($email_field = $poll->getPollClass()->emailField()) {
            $allowed_parameters = $poll->getPollClass()->allowedQueryParameters();

            if($context == 'save' || in_array($email_field, $allowed_parameters)) {
                if($request->input($email_field)) {
                    $user = Person::whereEmail($request->input($email_field))->first();
                }
            }

            if($user) {
                return $user;
            }
        }

        return null;
    }

    protected function showPoll(Request $request, PollProxy $poll_proxy) {
        $poll = $poll_proxy->getPoll();

        $user = $this->determineUser($request, $poll_proxy, 'display');

        $poll->getPollClass()->getDependencyContainer()->instance(Person::class, $user);

        $flow = $poll->resolveInterface(PollFlow::class);

        // raise 404 if anonymous responses are not allowed
        if(!$user && !$poll->getPollClass()->allowAnonymousDisplay()) {
            return $flow->getAnonymousErrorResponse();
        }

        if(!$user && !$poll->getPollClass()->allowAnonymousResponses() && !$poll->getPollClass()->emailField()) {
            return $flow->getAnonymousErrorResponse();
        }

        if(!$this->canPollBeAnswered($request, $poll_proxy, $user)) {
            return $flow->getAlreadyAnsweredErrorResponse();
        }

        return $flow->getFormResponse();
    }

    protected function savePollAnswer(PollFormRequest $request, PollProxy $poll_proxy) {
        $poll = $poll_proxy->getPoll();

        $user = $this->determineUser($request, $poll_proxy, 'save');

        $poll->getPollClass()->getDependencyContainer()->instance(Person::class, $user);

        $flow = $poll->resolveInterface(PollFlow::class);

        if(!$user && !$poll->getPollClass()->allowAnonymousResponses()) {
            return $flow->getAnonymousErrorResponse();
        }

        if(!$this->canPollBeAnswered($request, $poll_proxy, $user)) {
            return $flow->getAlreadyAnsweredErrorResponse();
        }

        $answer = new Answer;
        $answer->poll_id = $poll->id;
        if($user) {
            $answer->user_id = $user->id;
        }

        $answer->raw_answer = $request->getSanitizedData();

        // implicitly create person

        DB::transaction(function() use($poll, $answer) {
            $answer->save();

            try {
                $indexer = $poll->resolveInterface(PollAnswerIndexer::class);
                $indexer->saveIndexesOn($answer);
            } catch(CannotResolveInterface $e) {
            }
        });

        // one year in minutes
        if(!$poll->getPollClass()->allowMultipleResponses()) {
            Cookie::queue("poll:{$proxy->poll->key}", 'answered', 525600);
        }

        try {
            $mailer = $poll->resolveInterface(PollAnswerMailer::class);
            $mailer->send($answer);
        } catch(CannotResolveInterface $e) {
        }

        return $flow->getSuccessResponse($answer);
    }
}
