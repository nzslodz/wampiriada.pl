<?php namespace NZS\Wampiriada\Checkins\Friend;
use NZS\Wampiriada\Checkins\Checkin;

class FriendCheckinDecorator {
    protected $checkin;

    public function __construct(Checkin $checkin) {
        $this->checkin = $checkin;
    }

    protected function timeSorted($collection) {
        return $collection->sortBy(function($friend_checkin) {
            return $friend_checkin->friend_checkin->created_at->timestamp;
        });
    }

    public function getFriendCheckins() {
        return $this->checkin->friend_checkins;
    }

    protected function getUnsortedFriendCheckinsPresentOnAction() {
        return $this->checkin->friend_checkins->filter(function($friend_checkin) {
            return $friend_checkin->friend_checkin->action_day_id == $this->checkin->action_day_id;
        });
    }

    protected function getUnsortedFriendCheckinsNotPresentOnAction() {
        return $this->checkin->friend_checkins->filter(function($friend_checkin) {
            return $friend_checkin->friend_checkin->action_day_id != $this->checkin->action_day_id;
        });
    }

    public function getFriendCheckinsPresentOnAction() {
        return $this->timeSorted($this->getUnsortedFriendCheckinsPresentOnAction());
    }

    public function getFriendCheckinsPresentOnActionIncludingMe() {
        $collection = $this->getUnsortedFriendCheckinsPresentOnAction();

        $self = new FriendCheckin;
        $self->checkin_id = $this->checkin->id;
        $self->friend_checkin_id = $this->checkin->id;

        $collection->push($self);

        return $this->timeSorted($collection);
    }

    public function getFriendCheckinsNotPresentOnAction() {
        return $this->timeSorted($this->getUnsortedFriendCheckinsNotPresentOnAction());
    }

    public function getScore() {
        return 1 + $this->getUnsortedFriendCheckinsPresentOnAction()->count() + $this->getUnsortedFriendCheckinsNotPresentOnAction()->count() * 1.2;
    }

    public function getCheckin() {
        return $this->checkin;
    }

    public function getUser() {
        return $this->checkin->user;
    }

    public function isSelf($friend_checkin) {
        return $friend_checkin->friend_checkin->user_id == $this->checkin->user_id;
    }
}
