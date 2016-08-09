<?php namespace NZS\Core;

class ObjectLikeStorage {
    protected $array = [];

    public function __set($key, $value) {
        $this->array[$key] = $value;
    }

    public function __get($key) {
        return $this->array[$key];
    }

    public function __isset($key) {
        return isset($this->array[$key]);
    }

    public function __unset($key) {
        unset($this->array[$key]);
    }
}
