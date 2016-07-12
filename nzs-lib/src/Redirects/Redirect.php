<?php namespace NZS\Core\Redirects;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Core\Contracts\RedirectObject;

class Redirect extends Model implements RedirectObject  {
    public $timestamps = false;

    protected $fillable = ['key', 'url', 'class_name'];

    public function redirect() {
        return $this->url;
    }

    public function exists() {
        return true;
    }
}
