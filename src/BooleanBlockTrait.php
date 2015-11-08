<?php namespace NZS\Wampiriada;

trait BooleanBlockTrait {
    protected 
        $contents = [];

    public function open() {
        ob_start();
    }

    public function otherwise() {
        array_push($this->contents, ob_get_clean());
        ob_start();
    }

    public function close() {
        array_push($this->contents, ob_get_clean());
        
        echo $this->isTrue() ? $this->get(0) : $this->get(1);
    }

    public function get($key) {
        if(!isset($this->contents[$key])) {
            return '';
        }

        return $this->contents[$key];
    }

    abstract protected function isTrue();
}

