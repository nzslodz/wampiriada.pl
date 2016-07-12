<?php namespace NZS\Core\Contracts;

interface Redirect {
    public function asTag($contents, array $attrs=[]);
    public function asUrl();
    public function exists();
    public function redirect();
}
