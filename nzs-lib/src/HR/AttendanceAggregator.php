<?php namespace NZS\Core\HR;
use NZS\Core\HR\Event;
use NZS\Core\HR\Member;

class AttendanceAggregator {
    protected $event;
    protected $_members;
    protected $_attendances;

    public function __construct(Event $event) {
        $this->event = $event;

        $this->_members = Member::whereIsMember(true)->get()->mapWithKeys(function($member) {
            return [$member->id => $member];
        });

        $this->_attendances = $event->attendances->mapWithKeys(function($attendance) {
            return [$attendance->user_id => $attendance];
        });
    }

    public function getActiveMembers() {
        return $this->_members->transform(function($member, $key) {
            return new AttendanceProxy($this->_attendances->get($key), $member);
        });
    }

    public function getAttendedIds() {
        return $this->_attendances->keys()->all();
    }

    public function getOtherAttendees() {
        return $this->_attendances->filter(function($attendance, $key) {
            return !$this->_members->has($key);
        })->transform(function($attendance, $key) {
            return new AttendanceProxy($attendance);
        });
    }
}
