<?php namespace NZS\Core\Contracts;
use NZS\Core\Activity;

interface ActivityClass {
    public function resolveInterface($contract, Activity $activity);
}
