<?php namespace NZS\Core;

use LogicException;

use NZS\Core\Contracts\ActivityClass as ActivityClassContract;
use NZS\Core\Contracts\NeedsActivityContainer;

abstract class ActivityClass implements ActivityClassContract {
    protected $data = null;

    public function registerActivityEvent() {
        $model_class = $this->getModel();

        $model_class::creating(function($object) {
            $activity = $this->saveActivityInstance($object);

            $object->activity_id = $activity->id;
        });
    }

    public function getData(Activity $activity) {
        if(!$this->data) {
            $this->data = $this->loadData($activity);
        }

        return $this->data;
    }

    public function resolveInterface($contract, Activity $activity) {
        $class_or_object = $this->getInterface($contract);

        if(is_null($class_or_object)) {
            throw new LogicException("Cannot resolve interface $contract");
        }

        if(!is_object($class_or_object)) {
            $class_or_object = new $class_or_object;
        }

        if($class_or_object instanceof NeedsActivityContainer) {
            $class_or_object->setActivityContainer($this->getData($activity));
        }

        return $class_or_object;
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
