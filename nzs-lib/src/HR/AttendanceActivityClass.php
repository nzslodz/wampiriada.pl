<?php namespace NZS\Core\HR;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\HR\Attendance;
use NZS\Core\HR\AttendanceTimeline;


class AttendanceActivityClass extends ModelActivityClass {
    public function getModel() {
        return Attendance::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return AttendanceTimeline::class;
        }
    }

    public function loadData(ActivityContainer $container) {
        $container->event = $container->object->event;

        return $container;
    }

    public function getCreatedAt($attendance) {
        return $attendance->event->happened_at;
    }
}
