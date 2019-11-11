<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\School;

class Place extends Model {
	protected $table = 'wampiriada_action_places';

    public $timestamps = false;

    public function actions() {
        return $this->hasMany(ActionDay::class, 'place_id');
    }

	public function school() {
		return $this->belongsTo(School::class, 'school_id');
	}
}
