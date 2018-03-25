<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Editions\Edition;

use Carbon\Carbon;

class ActionDay extends Model {
	protected $table = 'action_days';

    public function place() {
        return $this->belongsTo(Place::class, 'place_id');
    }

	public function checkins() {
		return $this->hasMany(Checkin::class);
	}

	public function edition() {
		return $this->belongsTo(Edition::class);
	}

	public function getActionDate() {
		$date = new Carbon($this->created_at);

		return $date->format('Y-m-d');
	}
}
