<?php namespace NZS\Wampiriada\Checkins\Prize;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;
use NZS\Core\ActivityClass;

class PrizeForCheckinTimeline implements Timeline {
    use TimelineTrait;
    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        $text = '';
        foreach($data->object->items as $prize_type) {
            $text .= "<li>$prize_type->name</li>";
        }

        return [
            'start_date' => $this->convertToTimestampObject($data->activity->created_at),
            'group' => 'Oddanie krwi',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => 'Wygrana w konkursie',
                'text' => "<ol>$text</ol>",
            ],
        ];
    }

}
