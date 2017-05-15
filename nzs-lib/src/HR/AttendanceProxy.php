<?php namespace NZS\Core\HR;
use NZS\Core\HR\Member;
use NZS\Core\HR\Attendance;

class AttendanceProxy {
    protected $user;

    public $member;
    public $attendance;

    public function __construct(Attendance $attendance=null, Member $member=null) {
        if($member) {
            $this->member = $member;
            $this->user = $member->user;
        }

        if($attendance) {
            $this->attendance = $attendance;
            $this->user = $attendance->user;
        } else {
            $this->attendance = new Attendance;
        }
    }

    public function __get($key) {
        return $this->user->$key;
    }

    public function __call($key, $parameters) {
        return call_user_func_array([$this->user, $key], $parameters);
    }
}
