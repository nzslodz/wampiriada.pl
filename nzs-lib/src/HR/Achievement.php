<?php namespace NZS\Core\HR;

use Illuminate\Database\Eloquent\Model as Model;

use Carbon\Carbon;
use NZS\Core\Person;
use NZS\Core\Activity;
use NZS\Core\HR\AchievementType;

class Achievement extends Model {
    protected $table = 'hr_achievements';

    protected $dates = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function type() {
        return $this->belongsTo(AchievementType::class, 'type_id');
    }

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
