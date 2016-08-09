<?php namespace NZS\Wampiriada;
use NZS\Core\Polls\SimplePollFlow;
use NZS\Core\Polls\Answer;
use App\User;

class WampiriadaThankYouPollFlow extends SimplePollFlow {
    public function getFormResponse(User $user=null) {
        return view('wampiriada.polls.thankyou', [
            'user' => $user,
        ]);
    }

    public function getSuccessResponse(Answer $answer) {
        return view('wampiriada.polls.thankyou_complete');
    }
}
