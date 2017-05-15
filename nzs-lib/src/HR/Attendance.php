<?php namespace NZS\Core\HR;

use Illuminate\Database\Eloquent\Model as Model;

use Carbon\Carbon;
use NZS\Core\Person;
use NZS\Core\Activity;
use NZS\Core\HR\Event;
use NZS\Core\HR\AchievementType;

class Attendance extends Model {
    protected $table = 'nzs_attendances';

    protected $dates = ['created_at', 'updated_at', 'attended_since', 'attended_to'];

    protected $fillable = ['attended_to', 'attended_since', 'additional_notes', 'role'];

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
