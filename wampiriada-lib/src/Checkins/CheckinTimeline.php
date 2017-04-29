<?php namespace NZS\Wampiriada\Checkins;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;

class CheckinTimeline implements Timeline {
    use TimelineTrait;

    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        return [
            'start_date' => $this->convertToTimestampObject($data->object->created_at),
            'group' => 'Oddanie krwi',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => "{$data->edition->number}. edycja Wampiriady",
                'text' => "Oddano krew",
            ],
        ];
    }
}
