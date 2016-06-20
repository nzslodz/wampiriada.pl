<?php namespace NZS\Wampiriada;
use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Wampiriada\Checkin;
use NZS\Core\Contracts\Timeline;
use NZS\Core\SaveActivityInstanceTrait;

class FirstTimeDonatingActivityClass extends ActivityClass {
    use SaveActivityInstanceTrait;

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return FirstTimeDonatingTimeline::class;
        }
    }
}
