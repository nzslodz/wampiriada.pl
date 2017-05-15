<?php namespace NZS\Core\HR;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;

class AttendanceTimeline implements Timeline {
    use TimelineTrait;

    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        return [
            'start_date' => $this->convertToTimestampObject($data->event->happened_at),
            'group' => 'HR/Eventy',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => "{$data->event->name}",
                'text' => "Zanotowano uczestnictwo w roli {$data->object->role}",
            ],
        ];
    }
}
