<?php namespace NZS\Wampiriada;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Wampiriada\PrizeForCheckin;
use NZS\Wampiriada\PrizeForCheckinTimeline;

class PrizeForCheckinActivityClass extends ModelActivityClass {
    public function getModel() {
        return PrizeForCheckin::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return PrizeForCheckinTimeline::class;
        }
    }
}
