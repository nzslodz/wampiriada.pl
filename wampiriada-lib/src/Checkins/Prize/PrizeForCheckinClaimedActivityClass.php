<?php namespace NZS\Wampiriada\Checkins\Prize;
use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinClaimedTimeline;
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
