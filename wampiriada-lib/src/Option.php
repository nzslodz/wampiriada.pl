<?php namespace NZS\Wampiriada;

use Illuminate\Database\Eloquent\Model as Model;
use Config;

// XXX move me to NZS\Core namespace
class Option extends Model {
    public $timestamps = false;
    protected $guarded = array();

    public static function set($key, $value) {
        if($option = static::where('key', $key)->first()) {
            $option->value = $value;
            $option->save();

            return $option;
        }

        return static::create(array(
            'key' => $key,
            'value' => $value
        ));
    }

    public static function get($key, $default=null) {
        if($option = static::where('key', $key)->first()) {
            return $option->value;
        }

        if(Config::has($key)) {
            return Config::get($key);
        }

        return $default;
    }
}
