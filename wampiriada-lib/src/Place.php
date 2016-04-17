<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class Place extends Eloquent {
	protected $table = 'places';

    public function actions() {
        return $this->hasMany(ActionDay::class, 'place_id');
    }
}
