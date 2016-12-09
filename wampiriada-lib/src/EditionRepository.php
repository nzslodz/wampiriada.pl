<?php namespace NZS\Wampiriada;

use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Redirects\DatabaseRedirectRepository;
use NZS\Core\Redirects\CompositeRedirectRepository;
use NZS\Wampiriada\EmptyConfiguration;

class EditionRepository {
    protected
        $edition_number,
        $edition = null,
        $result,
        $actions,
        $redirects = array();

    public function __construct($edition=null) {
        if($edition instanceof Edition) {
            $this->edition = $edition;
            $this->edition_number = $edition->number;
        } elseif($edition) {
            $this->edition_number = $edition;
        } else {
            $this->edition_number = Option::get('wampiriada.edition', 28);
        }
    }

    public function getEditionNumber() {
        return $this->edition_number;
    }

    public function getEdition() {
        if(!$this->edition) {
            $this->edition = Edition::whereNumber($this->edition_number)->first();
        }

        return $this->edition;
    }

    public function getEditionType() {
        return $this->edition_number % 2 + 1;
    }

    public function getEditionYear() {
        return (int) ($this->edition_number / 2) + 2002;
    }

    public function getResults() {
        if($this->result) {
            return $this->result;
        }

        $this->result = OverallResult::where('year', $this->getEditionYear())
            ->where('edition_type', $this->getEditionType())
            ->first();

        if(!$this->result) {
            throw new ObjectDoesNotExist("There are no results for edition {$this->getEditionNumber()}.");
        }

        return $this->result;
    }

    public function getActions() {
        if($this->actions) {
            return $this->actions;
        }

        $this->actions = Action::where('number', $this->getEditionNumber())
            ->whereHidden(false)
            ->orderBy('day')
            ->get();

        if($this->actions->isEmpty()) {
            throw new ObjectDoesNotExist("There are no actions defined for edition {$this->getEditionNumber()}.");
        }

        return $this->actions;
    }

    public function getGalleryActions() {
        return $this->getActions()->filter(function($item) {
            return (bool) $item->gallery_link && (bool) $item->gallery_image;
        });
    }

    public function getOverall() {
        return $this->getResults()->overall;
    }

    public function safeGetOverall() {
        try {
            return $this->getOverall();
        } catch(ObjectDoesNotExist $e) {
            return 0;
        }
    }

    public function getOverallDifference(EditionRepository $repository) {
        return $this->getOverall() - $repository->getOverall();
    }

    public function getRedirectAsTag($name, $contents, array $attrs=array()) {
        return $this->getRedirect($name)->asTag($contents, $attrs);
    }

    public function getRedirectRepository() {
        $database_repository = new DatabaseRedirectRepository;
        $wampiriada_repository = new WampiriadaRedirectRepository($this);

        return new CompositeRedirectRepository([$wampiriada_repository, $database_repository]);
    }

    public function getRedirect($name) {
        return $this->getRedirectRepository()->getRedirect($name);
    }

    public function registerRedirect($key, $url, $edition_specific=true) {
        $wampiriada_repository = new WampiriadaRedirectRepository($this);

        return $wampiriada_repository->registerRedirect($key, $url);
    }

    public function getConfiguration() {
        $configuration = $this->getEdition()->configuration;

        if(!$configuration) {
            return new EmptyConfiguration;
        }

        return $configuration;
    }
}
