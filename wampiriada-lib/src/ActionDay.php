<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\ActionDayPresenter;

use Carbon\Carbon;

use Laracodes\Presenter\Traits\Presentable;

class ActionDay extends Model {
	use Presentable;

	protected $table = 'action_days';

	protected $dates = ['created_at'];

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

	public function edition() {
		return $this->belongsTo(Edition::class);
	}

	public function getStartAttribute($attr) {
        return Carbon::createFromFormat('H:i:s', $attr);
    }

    public function getEndAttribute($attr) {
        return Carbon::createFromFormat('H:i:s', $attr);
    }

	public function getShortDescriptionAttribute() {
		return "{$this->created_at->format('d/m')} {$this->place->name}";
	}
}
