<?php namespace NZS\Core\Redirects;

trait UsesRedirectTable {
    public function exists($name) {
        return $this->loadRedirect($name) instanceof Redirect;
    }

    public function resolveRedirect($name) {
        return $this->loadRedirect($name)->redirect();
    }
}
