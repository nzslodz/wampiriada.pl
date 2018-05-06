<?php namespace NZS\Wampiriada\Editions;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Redirects\WampiriadaRedirect;
use NZS\Core\Redirects\Redirect;

class EditionConfiguration extends Model {
    public $timestamps = false;

    protected $table = 'wampiriada_edition_meta';

	public function edition() {
		return $this->belongsTo(EditionConfiguration::class, 'id');
	}
}
