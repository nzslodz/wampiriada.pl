<?php namespace NZS\Wampiriada;

class EditionRepository {
    protected $edition, $result, $actions;

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

        if(!$this->actions) {
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
}

