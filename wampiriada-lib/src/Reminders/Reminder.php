<?php namespace NZS\Wampiriada\Reminders;

use Illuminate\Database\Eloquent\Model as Model;

use Carbon\Carbon;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Core\Person;
use NZS\Core\Activity;

class Reminder extends Model {
    protected $table = 'wampiriada_reminders';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['action_day_id', 'user_id'];

    protected $_checkin = false;

    public function action() {
        return $this->belongsTo(Action::class, 'action_day_id');
    }

    public function action_day() {
        return $this->belongsTo(ActionDay::class, 'action_day_id');
    }

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function getCheckin() {
        if($this->_checkin !== false) {
            return $this->_checkin;
        }

        $this->_checkin = Checkin::whereUserId($this->user_id)->whereEditionId($this->action_day->edition_id)->first();

        return $this->_checkin;
    }

    public function hasCheckin() {
        $checkin = $this->getCheckin();

        if(!$checkin) {
            return false;
        }

        return $checkin->action_day_id == $this->action_day_id;
    }

    public function hasAnyCheckin() {
        return (bool)$this->getCheckin();
    }
}
