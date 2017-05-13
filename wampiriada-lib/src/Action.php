<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Reminders\Reminder;
use NZS\Wampiriada\Editions\Edition;

class Action extends Model {
    protected $dates = ['day'];

    public function getStartAttribute($attr) {
        return Carbon::createFromFormat('H:i:s', $attr);
    }

    public function getEndAttribute($attr) {
        return Carbon::createFromFormat('H:i:s', $attr);
    }

    public function getShortDescriptionAttribute() {
        return "{$this->getDate()} {$this->place}";
    }

   	public function data() {
        return $this->hasOne(ActionData::class, 'id');
    }

    public function getDate() {
        $date = new Carbon($this->day);

        return $date->format('d/m');
    }

    public function checkins() {
        return $this->hasMany(Checkin::class, 'action_day_id');
    }

    public function reminders() {
        return $this->hasMany(Reminder::class, 'action_day_id');
    }
}
