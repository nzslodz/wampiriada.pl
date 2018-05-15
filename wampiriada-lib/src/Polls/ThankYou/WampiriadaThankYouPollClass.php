<?php namespace NZS\Wampiriada\Polls\ThankYou;
use NZS\Core\Polls\PollClass;
use NZS\Core\Polls\PollContainer;
use NZS\Core\Contracts\PollFlow;
use NZS\Wampiriada\Editions\EditionRepository;

class WampiriadaThankYouPollClass extends PollClass {
    public function allowMultipleResponses() {
        //return false;
        return true;
    }

    public function allowAnonymousResponses() {
        return false;
    }

    public function getInterface($contract) {
        if($contract == PollFlow::class) {
            return WampiriadaThankYouPollFlow::class;
        }
    }

    public function loadData(PollContainer $poll_container) {
        $wampiriada_poll = WampiriadaPoll::wherePollId($poll_container->poll->id)->first();

        $poll_container->wampiriada_poll = $wampiriada_poll;

        return $poll_container;
    }
}
