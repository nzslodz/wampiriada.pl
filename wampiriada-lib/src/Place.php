<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Wampiriada\School;

class Place extends Model {
	protected $table = 'places';

    public function actions() {
        return $this->hasMany(ActionDay::class, 'place_id');
    }

	public function school() {
		return $this->belongsTo(School::class, 'school_id');
	}
}
