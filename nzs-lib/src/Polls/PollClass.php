<?php namespace NZS\Core\Polls;

use LogicException;
use Carbon\Carbon;

use NZS\Core\Contracts\PollClass as PollClassContract;
use NZS\Core\Exceptions\CannotResolveInterface;
//use Illuminate\Container\Container;

abstract class PollClass implements PollClassContract {
    public function resolveInterface($contract, Poll $poll) {
        $class_or_object = $this->getInterface($contract);

        if(is_null($class_or_object)) {
            throw new CannotResolveInterface("Cannot resolve interface $contract");
        }

        if(!is_object($class_or_object)) {
            $class_or_object = app()->make($class_or_object);
        }

        return $class_or_object;
    }
}
