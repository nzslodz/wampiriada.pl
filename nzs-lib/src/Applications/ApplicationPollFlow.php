<?php namespace NZS\Core\Applications;

use NZS\Core\Polls\PollFlow;
use NZS\Core\Polls\Answer;
use App\User;

class ApplicationPollFlow extends PollFlow {
    protected $form_view = 'applications.polls.thankyou';
    protected $success_view = 'applications.polls.thankyou_complete';
    protected $already_answered_error_view = 'polls.already_answered';
    protected $anonymous_error_view = 'polls.anonymous_error';
}
