<?php namespace NZS\Wampiriada;
use NZS\Core\Polls\PollClass;
use NZS\Core\Contracts\PollFlow;

class WampiriadaThankYouPollClass extends PollClass {
    public function allowMultipleResponses() {
        return false;
    }

    public function allowAnonymousResponses() {
        return false;
    }

    public function getInterface($contract) {
        if($contract == PollFlow::class) {
            return WampiriadaThankYouPollFlow::class;
        }
    }
}
