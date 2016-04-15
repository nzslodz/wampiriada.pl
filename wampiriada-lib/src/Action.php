<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Carbon\Carbon;

class Action extends Model {
    protected $dates = ['day'];

    public function getStartAttribute($attr) {
        return Carbon::createFromFormat('H:i:s', $attr);
    }
    
    public function getEndAttribute($attr) {
        return Carbon::createFromFormat('H:i:s', $attr);
    }
}
