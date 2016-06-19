<?php namespace NZS\Core;

use LogicException;
use Carbon\Carbon;

use NZS\Core\Contracts\ActivityClass as ActivityClassContract;
use NZS\Core\Contracts\NeedsActivityContainer;
use NZS\Core\Contracts\NeedsActivityClass;
use NZS\Core\ActivityContainer;
use NZS\Core\Exceptions\CannotResolveInterface;
use NZS\Core\ActivityClass;
use Illuminate\Container\Container;

abstract class ActivityClass implements ActivityClassContract {
    protected $data = null;
    protected $container = null;

    public function getData(Activity $activity) {
        if(!$this->data) {
            $activity_container = new ActivityContainer($activity);

            $this->data = $this->loadData($activity_container);
        }

        return $this->data;
    }

    public function loadData(ActivityContainer $activity_container) {
        return $activity_container;
    }

    public function getDependencyContainer() {
        if($this->container) {
            return $this->container;
        }

        $container = new Container;
        $container->singleton(ActivityContainer::class, function($container) {
            return $this->getData($container->make(Activity::class));
        });

        $container->instance(ActivityClass::class, $this);

        $this->container = $container;

        return $this->container;
    }

    public function resolveInterface($contract, Activity $activity) {
        $class_or_object = $this->getInterface($contract);

        if(is_null($class_or_object)) {
            throw new CannotResolveInterface("Cannot resolve interface $contract");
        }

        if(!is_object($class_or_object)) {
            $container = $this->getDependencyContainer();

            // temporarily bind current activity to container, then resolve interface and unbind the instance
            $container->instance(Activity::class, $activity);
            $class_or_object = $container->make($class_or_object);
            $container->forgetInstance(Activity::class);
        }

        return $class_or_object;
    }
}
