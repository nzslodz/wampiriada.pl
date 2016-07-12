<?php namespace NZS\Core\Redirects;

use NZS\Core\Contracts\Redirect;
use NZS\Core\Contracts\RedirectRepository;

class RedirectProxy implements Redirect {
    use AsTagTrait;

    public function __construct(RedirectRepository $repository, $name) {
        $this->repository = $repository;
        $this->name = $name;
    }

    public function exists() {
        return $this->repository->exists($this->name);
    }

    public function asUrl() {
        return (string) $this->repository->generateUrl($this->name);
    }

    public function redirect() {
        return $this->repository->resolveRedirect($this->name);
    }

    public function __toString() {
        return $this->asUrl();
    }
}
