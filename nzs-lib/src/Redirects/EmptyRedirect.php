<?php namespace NZS\Core\Redirects;

use NZS\Core\Contracts\RedirectObject;

class EmptyRedirect implements RedirectObject {
    public function redirect() {
        return '';
    }

    public function exists() {
        return false;
    }
}
