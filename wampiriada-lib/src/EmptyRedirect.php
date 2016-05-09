<?php namespace NZS\Wampiriada;

use Silverplate\App;
use Netzmacht\Html\Element;

use App\Contracts\Redirect as RedirectContract;

class EmptyRedirect implements RedirectContract {
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

