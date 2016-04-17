<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;

class Profile extends Model {
    public $timestamps = false;
    
    protected $table = 'wampiriada_profile';

    protected $fillable = ['id'];
}
