<?php namespace NZS\Wampiriada;

use Silverplate\App;
use Netzmacht\Html\Element;

class EmptyRedirect {
    use BooleanBlockTrait;
    
    public function exists() {
        return false;
    }

    public function asUrl() {
        return '';
    }

    public function asTag($contents, array $attrs=array()) {
        return $contents;
    }
    
    protected function isTrue() {
        return $this->exists();
    }

    public function __toString() {
        return $this->asUrl();
    }
}

