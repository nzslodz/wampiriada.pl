<?php namespace NZS\Core\Contracts;

use NZS\Core\Activity;

interface Timeline extends NeedsActivityContainer {
    public function convertToTimelineObject();
}
