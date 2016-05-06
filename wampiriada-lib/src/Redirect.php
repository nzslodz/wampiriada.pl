<?php namespace NZS\Wampiriada;

use Silverplate\App;
use Netzmacht\Html\Element;
use Illuminate\Database\Eloquent\Model as Model;

class Redirect extends Model {
    use BooleanBlockTrait;

    public $timestamps = false;

    protected $fillable = ['key', 'url', 'edition_id'];

    public function exists() {
        return true;
    }

    public function asUrl() {
        if($this->edition_id) {
            return url("redirect/{$this->edition->number}/$this->key");
        }

        return url("redirect/$this->key");
    }

    public function asTag($contents, array $attrs=array()) {
        $attrs['href'] = $this->asUrl();

        return Element::create('a', $attrs)->addChild($contents);
    }

    protected function isTrue() {
        return $this->exists();
    }

    public function __toString() {
        return $this->asUrl();
    }

    public function edition() {
        return $this->belongsTo(Edition::class);
    }
}

