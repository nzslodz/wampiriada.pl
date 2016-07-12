<?php namespace NZS\Core\Redirects;

use NZS\Core\Contracts\Redirect;
use NZS\Core\Contracts\RedirectRepository;

abstract class BaseRedirectRepository implements RedirectRepository {
    public function getRedirect($name) {
        return new RedirectProxy($this, $name);
    }

    public function getRedirectAsTag($name, $contents, array $attrs=array()) {
        return $this->getRedirect($name)->asTag($contents, $attrs);
    }
}
