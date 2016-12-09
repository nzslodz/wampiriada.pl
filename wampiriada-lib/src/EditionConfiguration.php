<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\WampiriadaRedirect;
use NZS\Core\Redirects\Redirect;

class EditionConfiguration extends Model {
    public $timestamps = false;

	public function edition() {
		return $this->belongsTo(EditionConfiguration::class, 'id');
	}
}
