<?php namespace NZS\Core\Redirects;

use NZS\Core\Contracts\Redirect as RedirectContract;
use NZS\Core\Redirects\BaseRedirectRepository;
use NZS\Core\Redirects\EmptyRedirect;
use Purl\Url;

class CompositeRedirectRepository extends BaseRedirectRepository {
    protected
        $index_cache = [],
        $repository_list,
        $empty_repository;

    public function __construct(array $repository_list) {
        $this->repository_list = $repository_list;

        $this->empty_repository = new EmptyRedirectRepository();
    }

    protected function findRepositoryIndex($name) {
        foreach($this->repository_list as $index => $repository) {
            if($repository->exists($name)) {
                return $index;
            }
        }

        return false;
    }

    protected function findRepository($name) {
        if(!isset($this->index_cache[$name])) {
            $this->index_cache[$name] = $this->findRepositoryIndex($name);
        }

        if($this->index_cache[$name] === false) {
            return $this->empty_repository;
        }

        return $this->repository_list[$this->index_cache[$name]];
    }

    public function registerRedirect($name, $url, $options=[]) {
        throw new LogicException("CompositeRedirectRepository is read-only.");
    }

    public function generateUrl($name) {
        return $this->findRepository($name)->generateUrl($name);
    }

    public function resolveRedirect($name) {
        return $this->findRepository($name)->resolveRedirect($name);
    }

    public function exists($name) {
        return $this->findRepository($name)->exists($name);
    }

    public function getRedirectObject($name) {
        return $this->findRepository($name)->getRedirectObject($name);
    }

}
