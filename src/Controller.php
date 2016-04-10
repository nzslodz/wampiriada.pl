<?php namespace NZS\Application;

use Illuminate\Database\Capsule\Manager as Capsule;
use NZS\Wampiriada\EditionRepository;

class Controller {
    protected $capsule, $editions = array();
    
    public function __construct() {
        date_default_timezone_set("Europe/Warsaw");
        
        $this->capsule = new Capsule;

        $this->capsule->addConnection(require __DIR__ . '/../config/db.php');

        $this->capsule->bootEloquent();
    }

    public function getEdition($edition) {
        if(isset($this->editions[$edition])) {
            return $this->editions[$edition];
        }

        $this->editions[$edition] = new EditionRepository($edition);

        return $this->editions[$edition];
    }

    protected $school_mapping = array(
        'UŁ' => 'ul',
        'PŁ' => 'pl',
        'UMed' => 'um',
        'WSInfiU' => 'wsinf',
        'AHE' => 'ahe',
        'AMuz' => 'amuz',
        'ASP' => 'asp',
        'Pozostałe' => 'other',
    );

    public function getClass($short_name) {
        return $this->school_mapping[$short_name];
    }
}

