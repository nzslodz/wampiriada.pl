<?php namespace NZS\Core\Redirects;

use NZS\Core\Contracts\Redirect as RedirectContract;
use NZS\Core\Redirects\BaseRedirectRepository;
use Purl\Url;

class DatabaseRedirectRepository extends BaseRedirectRepository {
    use UsesRedirectTable;

    protected
        $redirect_cache = [];

    protected function loadRedirect($name) {
        if(!isset($this->redirect_cache[$name])) {
            $redirect = Redirect::whereKey($name)->whereClassName(get_class($this))->first();

            if(!$redirect) {
                $redirect = new EmptyRedirect;
            }

            $this->redirect_cache[$name] = $redirect;
        }

        return $this->redirect_cache[$name];
    }

    public function getRedirectObject($name) {
        return $this->loadRedirect($name);
    }

    public function registerRedirect($name, $url, $options=[]) {
        $this->redirect_cache[$name] = Redirect::firstOrCreate([
            'class_name' => get_class($this),
            'url' => $url,
            'key' => $name,
        ]);
    }

    public function generateUrl($name) {
        return new Url(url("redirect/$name"));
    }
}
