<?php namespace NZS\Core;

use LogicException;
use Carbon\Carbon;

use NZS\Core\Contracts\ActivityClass as ActivityClassContract;
use NZS\Core\ActivityContainer;
use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Exceptions\CannotResolveInteface;

abstract class ModelActivityClass extends ActivityClass {
    use SaveActivityInstanceTrait;

    protected $activity_field = 'activity_id';

    public function registerActivityEvent() {
        $model_class = $this->getModel();

        $model_class::creating(function($object) {
            $activity = $this->saveActivityInstance($object);

            $object->{$this->activity_field} = $activity->id;
        });

        $model_class::deleted(function($object) {
            Activity::whereId($object->{$this->activity_field})->delete();
        });
    }

    public function getData(Activity $activity) {
        $class = $this->getModel();

        $activity_container = new ActivityContainer($activity);
        $activity_container->object = $class::where($this->activity_field, '=', $activity->id)->first();

        if(!$activity_container->object) {
            throw new ObjectDoesNotExist("Object of class $class with $this->activity_field=$activity->id does not exist.");
        }

        return $this->loadData($activity_container);
    }

    public function removeIfStale(Activity $activity) {
        $class = $this->getModel();

        $object = $class::where($this->activity_field, '=', $activity->id)->first();

        if($object === null) {
            $activity->delete();

            return true;
        }

        return false;
    }
}
