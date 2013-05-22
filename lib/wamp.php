<?php 

class Wamp {
    protected $pdo, $results;

    public function __construct() {
        $this->pdo = include __DIR__ . '/db.php';
        $this->results = $this->pdo->query('SELECT overall, zero_plus, zero_minus, a_plus, a_minus, b_plus, b_minus, ab_plus, ab_minus, unknown FROM overall_results where year = "2013" and edition_type = "1"')->fetch(PDO::FETCH_ASSOC);
    }

    public function getData() {
        return $this->results;
    }
}

