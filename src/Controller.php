<?php namespace NZS\Application;

use Illuminate\Database\Capsule\Manager as Capsule;
use NZS\Wampiriada\EditionRepository;
use Silverplate\App;
use Dotenv\Dotenv;

class Controller {
    protected $capsule, $editions = array();
    
    public function __construct() {
        date_default_timezone_set("Europe/Warsaw");

        // Load database configuration through Dotenv
        $dotenv = new Dotenv(__DIR__ . '/..');
        $dotenv->load();

        $dotenv->required(['DB_DRIVER', 'DB_HOST', 'DB_USERNAME', 'DB_PASSWORD', 'DB_NAME']);

        // Create new Laravel Capsule and start Eloquent
        $this->capsule = new Capsule;

        $this->capsule->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_polish_ci',
            'prefix' => '',
        ]);

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

