<?php namespace NZS\Core;

use LogicException;
use Carbon\Carbon;

use NZS\Core\Contracts\ActivityClass as ActivityClassContract;
use NZS\Core\Contracts\NeedsActivityContainer;
use NZS\Core\ActivityContainer;
use NZS\Core\Exceptions\CannotResolveInteface;

abstract class ModelActivityClass extends ActivityClass {
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
            $class = $this->getModel();

            $activity_container = new ActivityContainer($activity);
            $activity_container->object = $class::whereActivityId($activity->id)->first();

            $this->data = $this->loadData($activity_container);
        }

        return $this->data;
    }

    public function saveActivityInstance($object, Carbon $created_at=null) {
        $activity = new Activity();
        $activity->class_name = get_class($this);

        if($object->user_id) {
            $activity->user_id = $object->user_id;
        } elseif(method_exists($object, 'getUser')) {
            $activity->user_id = $object->getUser()->id;
        } else {
            throw new LogicException("Object passed to saveActivityInstance must have user_id or getUser() method implemented");
        }

        if($created_at) {
            $activity->created_at = $created_at;
        } elseif($object->created_at) {
            $activity->created_at = $object->created_at;
        }

        $activity->save();

        return $activity;
    }
}
