<?php namespace NZS\Wampiriada;

use NZS\Core\Exceptions\ObjectDoesNotExist;

class EditionRepository {
    protected 
        $edition, 
        $result, 
        $actions,
        $redirects = array();

    public function __construct($edition) {
        $this->edition = $edition;
    }

    public function getEdition() {
        return $this->edition;
    }

    public function getEditionType() {
        return $this->edition % 2 + 1;
    }

    public function getEditionYear() {
        return (int) ($this->edition / 2) + 2002;
    }

    public function getResults() {
        if($this->result) {
            return $this->result;
        }

        $this->result = OverallResult::where('year', $this->getEditionYear())
            ->where('edition_type', $this->getEditionType())
            ->first();
        
        if(!$this->result) {
            throw new ObjectDoesNotExist("There are no results for edition {$this->getEdition()}.");    
        }

        return $this->result;
    }

    public function getActions() {
        if($this->actions) {
            return $this->actions;
        }
        
        $this->actions = Action::where('number', $this->getEdition())
            ->orderBy('day')
            ->get();

        if($this->actions->isEmpty()) {
            throw new ObjectDoesNotExist("There are no actions defined for edition {$this->getEdition()}.");    
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

    public function getOverallDifference(EditionRepository $repository) {
        return $this->getOverall() - $repository->getOverall();
    }

    public function addRedirect($name, $uri) {
        $this->redirects[$name] = new Redirect($uri);

        return $this->redirects[$name];
    }

    public function getRedirectAsTag($name, $contents, array $attrs=array()) {
        return $this->getRedirect($name)->asTag($contents, $attrs);
    }

    public function getRedirect($name) {
        if(isset($this->redirects[$name])) {
            return $this->redirects[$name];
        }

        return $this->addRedirect($name, url("redirect/{$this->getEdition()}/$name/"));
        
        /*if(file_exists(App::filePath('redirect', $this->getEdition(), "$name.redir"))) {
        }

        if(file_exists(App::filePath('redirect', "$name.redir"))) {
            return $this->addRedirect($name, url("redirect/$name/"));
        }*/

        return new EmptyRedirect();
    }
}

