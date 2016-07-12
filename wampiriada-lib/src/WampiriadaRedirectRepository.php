<?php namespace NZS\Wampiriada;

use NZS\Core\Contracts\Redirect as RedirectContract;
use NZS\Core\Contracts\RedirectRepository;
use NZS\Core\Redirects\BaseRedirectRepository;
use NZS\Core\Redirects\DatabaseRedirectRepository;
use NZS\Wampiriada\Edition;
use NZS\Core\Redirects\EmptyRedirect;
use NZS\Wampiriada\EditionRepository;
use NZS\Wampiriada\WampiriadaRedirect;
use Purl\Url;
use NZS\Core\Redirects\UsesRedirectTable;

class WampiriadaRedirectRepository extends BaseRedirectRepository {
    use UsesRedirectTable;

    protected
        $redirect_cache = null,
        $repository;

    public function __construct(EditionRepository $edition_repository) {
        $this->repository = $edition_repository;
    }

    protected function load() {
        $all_redirects = WampiriadaRedirect::with('redirect')->whereEditionId($this->repository->getEdition()->id)->get();

        $this->redirect_cache = [];

        foreach($all_redirects as $wampiriada_redirect) {
            $this->redirect_cache[$wampiriada_redirect->redirect->key] = $wampiriada_redirect->redirect;
        }

        return $this->redirect_cache;
    }

    protected function loadRedirect($name) {
        if($this->redirect_cache === null) {
            $this->load();
        }

        if(!isset($this->redirect_cache[$name])) {
            $this->redirect_cache[$name] = new EmptyRedirect;
        }

        return $this->redirect_cache[$name];
    }

    public function getRedirectObject($name) {
        return $this->loadRedirect($name);
    }

    public function registerRedirect($name, $url, $options=[]) {
        $redirect = Redirect::firstOrNew([
            'class_name' => get_class($this),
            'url' => $url,
            'key' => $name,
        ]);

        if(!$redirect->id) {
            $redirect->save();
            $this->repository->getEdition()->redirects()->save($redirect);
        }

        $this->redirect_cache[$name] = $redirect;
    }

    public function generateUrl($name) {
        return new Url(url("redirect/{$this->repository->getEditionNumber()}/$name"));
    }

}
