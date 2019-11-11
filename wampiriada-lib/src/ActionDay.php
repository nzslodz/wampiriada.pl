<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\ActionDayPresenter;
use NZS\Wampiriada\Reminders\Reminder;

use Carbon\Carbon;

use Laracodes\Presenter\Traits\Presentable;

// XXX move to own namespace?
class ActionDay extends Model {
	use Presentable;

	protected $table = 'wampiriada_action_meta';

	protected $dates = ['created_at'];

	protected $appends = ['can_remove'];

	protected $presenter = ActionDayPresenter::class;

	public function data() {
		return $this->hasOne(ActionData::class, 'id');
	}

    public function place() {
        return $this->belongsTo(Place::class, 'place_id');
    }

	public function checkins() {
		return $this->hasMany(Checkin::class);
	}

	public function getCanRemoveAttribute() {
		return $this->checkins->count() == 0;
	}

	public function edition() {
		return $this->belongsTo(Edition::class);
	}

	public function reminders() {
		return $this->hasMany(Reminder::class, 'action_day_id');
	}

	// XXX casts?
	public function getStartAttribute($attr) {
        if(!$attr) {
            return null;
        }

        return Carbon::createFromFormat('H:i:s', $attr);
    }

    public function getEndAttribute($attr) {
        if(!$attr) {
            return null;
        }

        return Carbon::createFromFormat('H:i:s', $attr);
    }

	public function getShortDescriptionAttribute() {
		return "{$this->created_at->format('d/m')} {$this->place->name}";
	}

	public function inPast() {
		return $this->created_at < Carbon::today();
	}

	public function inFuture() {
		return $this->created_at > Carbon::today();
	}
}
