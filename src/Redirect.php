<?php namespace NZS\Wampiriada;

use Silverplate\App;
use Netzmacht\Html\Element;

class Redirect {
    use BooleanBlockTrait;

    protected $url; 

    public function __construct($url) {
        $this->url = $url;
    }

    public function exists() {
        return true;
    }

    public function asUrl() {
        return $this->url;
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
}

