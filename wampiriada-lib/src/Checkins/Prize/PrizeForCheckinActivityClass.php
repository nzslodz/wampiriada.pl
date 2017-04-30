<?php namespace NZS\Wampiriada\Checkins\Prize;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinTimeline;

class PrizeForCheckinActivityClass extends ModelActivityClass {
    public function getModel() {
        return PrizeForCheckin::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return PrizeForCheckinTimeline::class;
        }
    }

    public function getUserId($prize) {
        return $prize->checkin->user_id;
    }
}
