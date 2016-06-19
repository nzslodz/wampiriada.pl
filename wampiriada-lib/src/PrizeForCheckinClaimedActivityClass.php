<?php namespace NZS\Wampiriada;
use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\PrizeForCheckin;
use NZS\Wampiriada\PrizeForCheckinClaimedTimeline;
use NZS\Core\Contracts\Timeline;
use NZS\Core\ActivityContainer;

class PrizeForCheckinClaimedActivityClass extends ActivityClass {
    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return PrizeForCheckinClaimedTimeline::class;
        }
    }

    public static function createFromPrize(PrizeForCheckin $prize) {
        $activity = new Activity();
        $activity->created_at = $prize->claimed_at;
        $activity->updated_at = $prize->claimed_at;
        $activity->user_id = $prize->getUser()->id;
        $activity->class_name = PrizeForCheckinClaimedActivityClass::class;
        $activity->save();

        return $activity;
    }
}
