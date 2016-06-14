<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityContainer;
use NZS\Core\RequiresActivityContainer;
use NZS\Core\Contracts\Timeline;

class CheckinTimeline implements Timeline {
    use RequiresActivityContainer;

    public function convertToTimelineObject() {
        $data = $this->getActivityContainer();

        return [
            'start_date' => [
                'month' => $data->checkin->created_at->format('m'),
                'year' => $data->checkin->created_at->format('Y'),
                'day' => $data->checkin->created_at->format('d'),
                'hour' => $data->checkin->created_at->format('H'),
                'minute' => $data->checkin->created_at->format('i'),
                'second' => $data->checkin->created_at->format('s')
            ],
            'group' => 'Oddanie krwi',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => "{$data->edition->number}. edycja Wampiriady",
                'text' => "Oddano krew",
            ],
        ];
    }
}
