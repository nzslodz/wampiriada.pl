<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Core\Polls\Poll;
use NZS\Core\Contracts\PollProxy;

class WampiriadaPoll extends Model implements PollProxy {
	public $timestamps = false;

	public $fillable = ['edition_id', 'poll_id'];

	public function poll() {
		return $this->belongsTo(Poll::class);
	}

	public function edition() {
		return $this->belongsTo(Edition::class);
	}

    public function getPoll() {
        return $this->poll;
    }
}
