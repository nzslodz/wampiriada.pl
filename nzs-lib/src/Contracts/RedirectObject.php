<?php namespace NZS\Core\Contracts;

interface RedirectObject {
    public function exists();
    public function redirect();
}
