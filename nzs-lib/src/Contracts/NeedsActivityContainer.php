<?php namespace NZS\Core\Contracts;

use NZS\Core\ActivityContainer;

interface NeedsActivityContainer {
    public function setActivityContainer(ActivityContainer $container);
    public function getActivityContainer();
}
