<?php namespace NZS\Core\Polls;

use LogicException;
use Carbon\Carbon;

use NZS\Core\Contracts\PollClass as PollClassContract;
use NZS\Core\Exceptions\CannotResolveInterface;
use NZS\Core\Polls\CookieResolver;
use Illuminate\Container\Container;

abstract class PollClass implements PollClassContract {
    protected $container = null;

    public function getData(Poll $poll) {
        $poll_container = new PollContainer($poll);

        return $this->loadData($poll_container);
    }

    public function loadData(PollContainer $poll_container) {
        return $poll_container;
    }

    public function getDependencyContainer() {
        if($this->container) {
            return $this->container;
        }

        $container = new Container;
        $container->instance(PollClass::class, $this);

        $this->container = $container;

        return $this->container;
    }

    public function resolveInterface($contract, Poll $requested_poll) {
        $class_or_object = $this->getInterface($contract);

        if(is_null($class_or_object)) {
            throw new CannotResolveInterface("Cannot resolve interface $contract");
        }

        if(!is_object($class_or_object)) {
            $container = $this->getDependencyContainer();

            $current_poll = $container->make(Poll::class);

            // rebind poll and its data to the container if needed
            if($current_poll->id != $requested_poll->id) {
                $container->instance(Poll::class, $requested_poll);
                $container->singleton(PollContainer::class, function($container) {
                    return $this->getData($container->make(Poll::class));
                });
            }

            $class_or_object = $container->make($class_or_object);
        }

        return $class_or_object;
    }
}
