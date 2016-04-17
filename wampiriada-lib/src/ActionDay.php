<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class ActionDay extends Model {
	protected $table = 'action_days';

    public function place() {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
