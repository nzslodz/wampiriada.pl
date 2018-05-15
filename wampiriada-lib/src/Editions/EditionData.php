<?php namespace NZS\Wampiriada\Editions;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Wampiriada\Redirects\WampiriadaRedirect;
use NZS\Core\Redirects\Redirect;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Checkins\Checkin;

class EditionData extends Model {
	protected $table = 'wampiriada_edition_data';

    public $timestamps = false;

    public function edition() {
        return $this->belongsTo(EditionConfiguration::class, 'id');
    }
}
