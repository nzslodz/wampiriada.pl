<?php namespace App\Contracts;

interface Redirect {
    public function asUrl();
    public function exists();
}
