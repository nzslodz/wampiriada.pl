<?php namespace NZS\Core\Polls;

use App\Http\Requests;
use Illuminate\Http\Request;
use NZS\Core\Polls\Poll;
use NZS\Core\Person;
use NZS\Core\Polls\Answer;
use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Exceptions\CannotResolveInterface;
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

        // use soft, runtime version of abstract method definition based on allowMultipleResponses() conditional
        if(!$poll->getPollClass()->allowMultipleResponses() && !method_exists($this, 'getCookieNameForPoll')) {
            $class_name = get_class($this);
            $poll_class_name = get_class($poll->getPollClass());

            throw new RuntimeException("$class_name does not define getCookieNameForPoll() method when $poll_class_name::allowMultipleResponses() is set to false");
        }

        if(!$poll->getPollClass()->allowMultipleResponses()) {
            if($user && Answer::whereUserId($user->id)->wherePollId($poll->id)->first()) {
                return false;
            }

            if($request->cookie($this->getCookieNameForPoll($poll_proxy)) == 'answered') {
                return false;
            }
        }

        return true;
    }

    protected function showPoll(Request $request, PollProxy $poll_proxy) {
        $poll = $poll_proxy->getPoll();

        // determine user
        if(Auth::check()) {
            $user = Auth::user()->person;
        } elseif($request->input('m')) {
            $user = Person::whereCampaignToken($request->input('m'))->first();
        } else {
            $user = null;
        }

        $poll->getPollClass()->getDependencyContainer()->instance(Person::class, $user);

        $flow = $poll->resolveInterface(PollFlow::class);

        // raise 404 if anonymous responses are not allowed
        if(!$user && !$poll->getPollClass()->allowAnonymousResponses()) {
            return $flow->getAnonymousErrorResponse();
        }

        if(!$this->canPollBeAnswered($request, $poll_proxy, $user)) {
            return $flow->getAlreadyAnsweredErrorResponse();
        }

        return $flow->getFormResponse();
    }

    protected function savePollAnswer(PollFormRequest $request, PollProxy $poll_proxy) {
        $poll = $poll_proxy->getPoll();

        $user_id = $request->input('user_id');
        $user = Person::find($user_id);

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
            Cookie::queue($this->getCookieNameForPoll($poll_proxy), 'answered', 525600);
        }

        try {
            $mailer = $poll->resolveInterface(PollAnswerMailer::class);
            $mailer->send($answer);
        } catch(CannotResolveInterface $e) {
        }

        return $flow->getSuccessResponse($answer);
    }
}
