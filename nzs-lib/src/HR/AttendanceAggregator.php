<?php namespace NZS\Core\HR;
use NZS\Core\HR\Event;
use NZS\Core\HR\Member;

class AttendanceAggregator {
    protected $event;

    public function __construct(Event $event) {
        $this->event = $event;
    }

    public function getAttendees() {
        return $event->attendees;
    }

    public function getMembers() {
        if($this->_members) {
            return $this->_members;
        }

        $this->_members = Member::whereIsMember(true)->get();

        return $this->_members;
    }

    public function getMemberAttendees() {
        $member_ids = $this->getMembers()->pluck('id');

        return $this->attendees->filter(function($value) use($member_ids) {
            return $member_ids->contains($value->id);
        });
    }

    public function getOtherAttendees() {
        $member_ids = $this->getMembers()->pluck('id');

        return $this->attendees->filter(function($value) use($member_ids) {
            return !$member_ids->contains($value->id);
        });
    }
}
