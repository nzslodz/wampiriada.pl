<?php namespace NZS\Wampiriada\Polls\ThankYou;
use NZS\Core\Polls\PollFlow;
use NZS\Core\Polls\Answer;

class WampiriadaThankYouPollFlow extends PollFlow {
    protected $form_view = 'wampiriada.polls.thankyou';
    protected $success_view = 'wampiriada.polls.thankyou_complete';
}
