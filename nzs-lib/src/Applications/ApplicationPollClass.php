<?php namespace NZS\Core\Applications;

use NZS\Core\Polls\PollClass;
use NZS\Core\Polls\PollContainer;
use NZS\Core\Contracts\PollFlow;
use NZS\Core\Contracts\PollAnswerMailer;
use NZS\Core\Contracts\PollAnswerIndexer;

class ApplicationPollClass extends PollClass {
    public function allowMultipleResponses() {
        return false;
    }

    public function allowAnonymousResponses() {
        return true;
    }

    public function allowMatchingUserByEmailField() {
        return true;
    }

    public function getInterface($contract) {
        if($contract == PollFlow::class) {
            return ApplicationPollFlow::class;
        } elseif($contract == PollAnswerMailer::class) {
            return ApplicationPollAnswerMailer::class;
        } elseif($contract == PollAnswerIndexer::class) {
            return ApplicationPollAnswerIndexer::class;
        }
    }
}
