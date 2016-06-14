<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;

class CheckinActivityClass extends ActivityClass {
    public function getModel() {
        return Checkin::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return CheckinTimeline::class;
        }
    }

    public function loadData(Activity $activity) {
        $container = new ActivityContainer($activity);

        $container->checkin = Checkin::whereActivityId($activity->id)->first();
        $container->edition = Edition::whereId($container->checkin->edition_id)->first();

        return $container;
    }
}
