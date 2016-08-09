<?php namespace NZS\Core\Polls;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use NZS\Core\Polls\Poll;
use NZS\Core\Polls\Answer;
use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Exceptions\CannotResolveInterface;
use NZS\Core\Contracts\PollFormRequest;
use NZS\Core\Contracts\PollFlow;
use NZS\Core\Contracts\PollProxy;
use NZS\Core\Contracts\PollAnswerIndexer;
use NZS\Core\Contracts\PollAnswerMailer;
use Auth;

use Cookie;

trait UsesPolls {
    protected function canPollBeAnswered(Request $request, PollProxy $poll_proxy, User $user=null) {
        $poll = $poll_proxy->getPoll();

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

    abstract protected function getCookieNameForPoll($poll);

    protected function showPoll(Request $request, PollProxy $poll_proxy) {
        $poll = $poll_proxy->getPoll();

        // determine user
        if(Auth::check()) {
            $user = Auth::user();
        } elseif($request->input('m')) {
            $user = User::whereMd5email($request->input('m'))->first();
        } else {
            $user = null;
        }

        $flow = $poll->resolveInterface(PollFlow::class);

        // raise 404 if anonymous responses are not allowed
        if(!$user && !$poll->getPollClass()->allowAnonymousResponses()) {
            return $flow->getAnonymousErrorResponse();
        }

        if(!$this->canPollBeAnswered($request, $poll_proxy, $user)) {
            return $flow->getAlreadyAnsweredErrorResponse();
        }

        return $flow->getFormResponse($user);
    }

    protected function savePollAnswer(PollFormRequest $request, PollProxy $poll_proxy) {
        $poll = $poll_proxy->getPoll();

        $user_id = $request->input('user_id');
        $user = User::find($user_id);

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

        $answer->save();

        // one year in minutes
        Cookie::queue($this->getCookieNameForPoll($poll_proxy), 'answered', 525600);

        try {
            $indexer = $poll->resolveInterface(PollAnswerIndexer::class);
            $indexer->saveIndexesOn($answer);
        } catch(CannotResolveInterface $e) {
        }

        try {
            $mailer = $poll->resolveInterface(PollAnswerMailer::class);
            $mailer->send($answer);
        } catch(CannotResolveInterface $e) {
        }

        return $flow->getSuccessResponse($answer);
    }
}
