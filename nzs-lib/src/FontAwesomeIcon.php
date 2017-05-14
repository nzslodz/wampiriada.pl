<?php namespace NZS\Core;

use RuntimeException;
use Illuminate\Contracts\Support\Htmlable;

class FontAwesomeIcon implements Htmlable {
    protected $icon_class;

    protected $other_classes;
    protected $title;
    protected $display = true;

    public function __construct($icon_class, $title='') {
        $this->icon_class = $icon_class;
        $this->other_classes = [];
        $this->title = $title;
    }

    public function withClass($class) {
        $this->other_classes[] = $class;
        return $this;
    }

    public function danger() {
        return $this->withClass('text-danger');
    }

    public function normal() {
        return $this->withClass('text-default');
    }

    public function success() {
        return $this->withClass('text-success');
    }

    public function info() {
        return $this->withClass('text-info');
    }

    public function primary() {
        return $this->withClass('text-primary');
    }

    public function muted() {
        return $this->withClass('text-muted');
    }

    public function warning() {
        return $this->withClass('text-warning');
    }

    public function none() {
        $this->display = false;
        return $this;
    }

    public function __call($method_name_text, $params) {
        $method_name = explode('_', snake_case($method_name_text));

        if(count($method_name) !== 3 || $method_name[1] !== 'or') {
            throw new RuntimeException("Invalid method $method_name_text.");
        }

        $value = $params[0];

        if($value) {
            $method = $method_name[0];
        } else {
            $method = $method_name[2];
        }

        return $this->$method();
    }


    public function toHtml() {
        if(!$this->display) {
            return '';
        }

        return sprintf('<i class="fa fa-%s %s" title="%s"></i>', $this->icon_class, join(' ', $this->other_classes), $this->title);
    }
}
