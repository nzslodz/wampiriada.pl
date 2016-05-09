<?php namespace NZS\Wampiriada;

use NZS\Core\Exceptions\ObjectDoesNotExist;

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

    public function getRedirect($name) {
        if(isset($this->redirects[$name])) {
            return $this->redirects[$name];
        }

        $this->redirects[$name] = Redirect::whereKey($name)->whereEditionId($this->getEdition()->id)->where('url', '!=', '')->first();
        
        if(!$this->redirects[$name]) {
            $this->redirects[$name] = Redirect::whereKey($name)->whereNull('edition_id')->first();
        }

        if(!$this->redirects[$name]) {
            $this->redirects[$name] = new EmptyRedirect();
        }

        return $this->redirects[$name];
    }

    public function registerRedirect($key, $url, $edition_specific=true) {
        if($edition_specific) {
            $redirect = Redirect::whereKey($key)->whereEditionId($this->getEdition()->id)->first();
        } else {
            $redirect = Redirect::whereKey($key)->whereNull('edition_id')->first();
        }

        if(!$redirect) {
            $redirect = Redirect::create([
                'edition_id' => ($edition_specific) ? $this->getEdition()->id : null,
                'url' => $url,
                'key' => $key,
            ]);
        }

        $this->redirects[$key] = $redirect;

        return $redirect;
    }
}

