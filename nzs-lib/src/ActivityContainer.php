<?php namespace NZS\Core;

class ActivityContainer extends ObjectLikeStorage {
    public function __construct(Activity $activity) {
        $this->activity = $activity;
    }
}
