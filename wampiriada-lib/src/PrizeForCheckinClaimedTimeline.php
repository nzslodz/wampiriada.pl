<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;
use NZS\Core\ActivityClass;

class PrizeForCheckinClaimedTimeline implements Timeline {
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
                'headline' => 'Odebranie nagrody',
                'text' => 'Nagroda została odebrana przez osobę biorącą udział w konkursie',
            ],
        ];
    }

}
