<?php namespace NZS\Core;

use NZS\Core\ActivityContainer;

trait RequiresActivityContainer {
    protected $container;

    public function setActivityContainer(ActivityContainer $container) {
        $this->container = $container;
    }

    public function getActivityContainer() {
        return $this->container;
    }
}
