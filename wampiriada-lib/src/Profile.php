<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class Profile extends Model {
    public $timestamps = false;

    protected $table = 'wampiriada_profile';

    protected $fillable = ['id'];

    public function getNameAsPair() {
    	$list = explode(' ', $this->current_name);

    	if(count($list) != 2) {
    		return [null, null];
    	}

    	return $list;
    }
}
