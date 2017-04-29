<?php namespace NZS\Wampiriada\Checkins;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Wampiriada\Editions\Edition;

class CheckinActivityClass extends ModelActivityClass {
    public function getModel() {
        return Checkin::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return CheckinTimeline::class;
        }
    }

    public function loadData(ActivityContainer $container) {
        $container->edition = Edition::whereId($container->object->edition_id)->first();

        return $container;
    }
}
