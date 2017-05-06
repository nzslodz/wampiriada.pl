<?php namespace NZS\Core\HR;

use Illuminate\Database\Eloquent\Model as Model;

use Carbon\Carbon;
use NZS\Core\Person;
use NZS\Core\Activity;
use NZS\Core\HR\AchievementType;

class Event extends Model {
    protected $table = 'nzs_events';

    protected $dates = ['created_at', 'updated_at', 'happened_at'];
}
