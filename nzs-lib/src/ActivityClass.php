<?php namespace NZS\Core;

use LogicException;
use Carbon\Carbon;

use NZS\Core\Contracts\ActivityClass as ActivityClassContract;
use NZS\Core\ActivityContainer;
use NZS\Core\Exceptions\CannotResolveInterface;
use NZS\Core\ActivityClass;
use Illuminate\Container\Container;

abstract class ActivityClass implements ActivityClassContract {
    protected $container = null;

    public function getData(Activity $activity) {
        $activity_container = new ActivityContainer($activity);

        return $this->loadData($activity_container);
    }

    public function loadData(ActivityContainer $activity_container) {
        return $activity_container;
    }

    public function getDependencyContainer() {
        if($this->container) {
            return $this->container;
        }

        $container = new Container;
        $container->instance(ActivityClass::class, $this);

        $this->container = $container;

        return $this->container;
    }

    public function resolveInterface($contract, Activity $requested_activity) {
        $class_or_object = $this->getInterface($contract);

        if(is_null($class_or_object)) {
            throw new CannotResolveInterface("Cannot resolve interface $contract");
        }

        if(!is_object($class_or_object)) {
            $container = $this->getDependencyContainer();

            $current_activity = $container->make(Activity::class);

            // bind activity and its data to the container once until activity with another id is requested
            if($current_activity->id != $requested_activity->id) {
                $container->instance(Activity::class, $requested_activity);
                $container->singleton(ActivityContainer::class, function($container) {
                    return $this->getData($container->make(Activity::class));
                });
            }

            $class_or_object = $container->make($class_or_object);
        }

        return $class_or_object;
    }
}
