<?php namespace NZS\Wampiriada;
use NZS\Core\Polls\PollFlow;
use NZS\Core\Polls\Answer;
use App\User;

class WampiriadaThankYouPollFlow extends PollFlow {
    protected $form_view = 'wampiriada.polls.thankyou';
    protected $success_view = 'wampiriada.polls.thankyou_complete';
}
