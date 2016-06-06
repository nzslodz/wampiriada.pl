<?php namespace NZS\Core;

use NZS\Core\Contracts\ActivityClass as ActivityClassContract;

abstract class ActivityClass implements ActivityClassContract {
    public function registerActivityEvent() {
        $model_class = $this->getModel();

        $model_class::creating(function($object) {
            $activity = $this->saveActivityInstance($object);

            $object->activity_id = $activity->id;
        });
    }

    public function saveActivityInstance($object) {
        $activity = new Activity();
        $activity->class_name = get_class($this);
        $activity->user_id = $object->user_id;
        if($object->created_at) {
            $activity->created_at = $object->created_at;
        }
        $activity->save();

        return $activity;
    }
}
