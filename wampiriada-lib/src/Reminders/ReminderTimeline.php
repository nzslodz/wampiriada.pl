<?php namespace NZS\Wampiriada\Reminders;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;
use NZS\Core\ActivityClass;

class ReminderTimeline implements Timeline {
    use TimelineTrait;
    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        $text = "<strong>{$data->action->day->format('d.m')} {$data->action->place}</strong> {$data->action->start->format('H:i')} - {$data->action->end->format('H:i')}";

        if($data->action->marrow) {
            $text .= " +SZPIK TO ME";
        }

        return [
            'start_date' => $this->convertToTimestampObject($data->activity->created_at),
            'group' => 'Przypomnienia',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => $data->action->day->format('d.m') . ' Wampiriada',
                'text' => $text,
            ],
        ];
    }

}
