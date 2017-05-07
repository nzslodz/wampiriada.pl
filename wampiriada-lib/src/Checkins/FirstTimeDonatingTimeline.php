<?php namespace NZS\Wampiriada\Checkins;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;

class FirstTimeDonatingTimeline implements Timeline {
    use TimelineTrait;
    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        return [
            'start_date' => $this->convertToTimestampObject($data->activity->created_at),
            'group' => 'Oddanie krwi',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => 'Krew oddana po raz pierwszy!',
                'text' => 'Ta osoba oddała krew po raz pierwszy na akcji Wampiriady',
            ],
        ];
    }

}
