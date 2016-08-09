<?php namespace NZS\Core\Polls;
use NZS\Core\Contracts\PollFlow;

abstract class SimplePollFlow implements PollFlow {
    public function getAnonymousErrorResponse() {
        abort(558);
    }

    public function getAlreadyAnsweredErrorResponse() {
        abort(559);
    }
}
