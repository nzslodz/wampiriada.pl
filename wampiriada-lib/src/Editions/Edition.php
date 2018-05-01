<?php namespace NZS\Wampiriada\Editions;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Wampiriada\Redirects\WampiriadaRedirect;
use NZS\Core\Redirects\Redirect;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Editions\EditionData;

class Edition extends Model {
	protected $table = 'editions';
    protected $repository = null;

    public $timestamps = false;

	// getters - public API
	public function getStartDate() {
		return new Carbon($this->start_date);
	}

	public function getEndDate() {
		return new Carbon($this->end_date);
	}

	// eloquent getters
	public function data() {
		return $this->hasOne(EditionData::class, 'id');
	}

	public function configuration() {
		return $this->hasOne(EditionConfiguration::class, 'id');
	}

	public function checkins() {
		return $this->hasMany(Checkin::class);
	}

	public function redirects() {
		return $this->belongsToMany(Redirect::class, 'wampiriada_redirects');
	}
}
