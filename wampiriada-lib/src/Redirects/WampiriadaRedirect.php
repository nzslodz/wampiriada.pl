<?php namespace NZS\Wampiriada\Redirects;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;
use NZS\Core\Redirects\Redirect;
use NZS\Wampiriada\Editions\Edition;

class WampiriadaRedirect extends Model {
	public $timestamps = false;

	public $fillable = ['edition_id', 'redirect_id'];

	public function redirect() {
		return $this->belongsTo(Redirect::class);
	}

	public function edition() {
		return $this->belongsTo(Edition::class);
	}
}
