<?php namespace NZS\Core\Polls;
use NZS\Core\Contracts\PollFlow as PollFlowContract;
use NZS\Core\Polls\PollContainer;
use NZS\Core\Person;

abstract class PollFlow implements PollFlowContract {
    protected $data, $user;

    protected $already_answered_error_view = 'polls.already_answered';
    protected $anonymous_error_view = 'polls.anonymous_error';
    protected $form_view = null;
    protected $success_view = null;

    public function __construct(PollContainer $poll_container, Person $user) {
        $this->data = $poll_container;
        $this->user = $user;
    }

    protected function getViewContext(array $specific_context=[]) {
        return [
            'poll' => $this->data->poll,
            'user' => $this->user,
            'container' => $this->data,
        ] + $specific_context + $this->getExtraContext();
    }

    protected function getExtraContext() {
        return [];
    }

    public function getAnonymousErrorResponse() {
        return view($this->anonymous_error_view, $this->getViewContext());
    }

    public function getAlreadyAnsweredErrorResponse() {
        return view($this->already_answered_error_view, $this->getViewContext());
    }

    public function getFormResponse() {
        return view($this->form_view, $this->getViewContext());
    }

    public function getSuccessResponse(Answer $answer) {
        return view($this->success_view, $this->getViewContext([
            'answer' => $answer,
        ]));
    }
}
