<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityClass;

class CheckinActivityClass extends ActivityClass {
    public function getModel() {
        return Checkin::class;
    }
}
