<?php namespace NZS\Wampiriada;
use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\PrizeForCheckin;
use NZS\Wampiriada\PrizeForCheckinClaimedTimeline;
use NZS\Core\Contracts\Timeline;
use NZS\Core\ActivityContainer;

use NZS\Core\SaveActivityInstanceTrait;

class PrizeForCheckinClaimedActivityClass extends ActivityClass {
    use SaveActivityInstanceTrait;

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return PrizeForCheckinClaimedTimeline::class;
        }
    }

    public function getCreatedAt($prize) {
        return $prize->claimed_at;
    }

    public function getUserId($prize) {
        return $prize->checkin->user_id;
    }
}
