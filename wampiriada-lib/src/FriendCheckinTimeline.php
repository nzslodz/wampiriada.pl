<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;

class FriendCheckinTimeline implements Timeline {
    use TimelineTrait;

    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        if($data->different_action) {
            $headline = "{$data->friend_checkin->user->getFullName()} oddaje krew";
        } else {
            $headline = "{$data->friend_checkin->user->getFullName()} oddaje krew na akcji";
        }

        return [
            'start_date' => $this->convertToTimestampObject($data->activity->created_at),
            'group' => 'Oddanie krwi',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => $headline,
                'text' => "Znajomy na Facebooku oddaje krew. <a data-card=\"{$data->friend_checkin->user_id}\"  title=\"{$data->friend_checkin->user->getFullName()}\" href=\"" .url('admin/activity/profile/' . $data->friend_checkin->user_id ) . "\">Zobacz aktywność</a>.",
            ],
        ];
    }
}
