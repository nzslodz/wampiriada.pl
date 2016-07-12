<?php namespace NZS\Core\Redirects;

use NZS\Core\Contracts\Redirect as RedirectContract;
use NZS\Core\Redirects\BaseRedirectRepository;
use NZS\Core\Redirects\EmptyRedirect;
use Purl\Url;

class EmptyRedirectRepository extends BaseRedirectRepository {
    public function registerRedirect($name, $url, $options=[]) {
    }

    public function generateUrl($name) {
        return '';
    }

    public function resolveRedirect($name) {
        return '';
    }

    public function exists($name) {
        return false;
    }

    public function getRedirectObject($name) {
        return new EmptyRedirect();
    }
}
