<?php namespace NZS\Wampiriada;
use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Wampiriada\Checkin;
use NZS\Core\Contracts\Timeline;

class FirstTimeDonatingActivityClass extends ActivityClass {
    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return FirstTimeDonatingTimeline::class;
        }
    }

    public static function createFromCheckin(Checkin $checkin) {
        $activity = new Activity();
        $activity->created_at = $checkin->created_at;
        $activity->updated_at = $checkin->updated_at;
        $activity->user_id = $checkin->user_id;
        $activity->class_name = FirstTimeDonatingActivityClass::class;
        $activity->save();

        return $activity;
    }
}
