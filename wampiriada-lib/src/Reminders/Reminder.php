<?php namespace NZS\Wampiriada\Reminders;

use Illuminate\Database\Eloquent\Model as Model;

use Carbon\Carbon;
use NZS\Wampiriada\ActionDay;
use NZS\Core\Person;
use NZS\Core\Activity;

class Reminder extends Model {
    protected $table = 'wampiriada_reminders';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['action_day_id', 'user_id'];

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
}
