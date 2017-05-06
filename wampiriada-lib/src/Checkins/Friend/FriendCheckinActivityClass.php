<?php namespace NZS\Wampiriada\Checkins\Friend;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckin;
use NZS\Wampiriada\Checkins\Friend\FriendCheckinTimeline;
use NZS\Wampiriada\Checkins\Prize\PrizeForCheckinTimeline;

class FriendCheckinActivityClass extends ModelActivityClass {
    public function getModel() {
        return FriendCheckin::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return FriendCheckinTimeline::class;
        }
    }

    public function getCreatedAt($friend_checkin) {
        return $friend_checkin->friend_checkin->created_at;
    }

    public function getUserId($friend_checkin) {
        return $friend_checkin->checkin->user_id;
    }

    public function loadData(ActivityContainer $container) {
        $container->checkin = $container->object->checkin;
        $container->friend_checkin = $container->object->friend_checkin;
        $container->different_action = $container->checkin->action_day_id != $container->friend_checkin->action_day_id;

        return $container;
    }
}
