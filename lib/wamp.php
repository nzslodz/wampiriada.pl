<?php 

class Wamp {
    protected $pdo, $results, $actions, $edition;

    protected $school_mapping = array(
        'UŁ' => 'ul',
        'PŁ' => 'pl',
        'UMed' => 'um',
        'WSInfiU' => 'wsinf',
        'AHE' => 'ahe',
        'Pozostałe' => 'other',
    );

    public function getEdition() {
        return $this->edition;
    }

    public function getEditionType($edition=null) {
        if($edition === null) {
            $edition = $this->getEdition();
        }

        return $edition % 2 + 1;
    }

    public function getYear($edition) {
        if($edition === null) {
            $edition = $this->getEdition();
        }

        return (int) ($edition / 2) + 2002;
    }

    public function __construct($edition) {
        $this->pdo = include __DIR__ . '/db.php';
        $this->edition = $edition;

        $this->results = $this->pdo->query("SELECT overall, zero_plus, zero_minus, a_plus, a_minus, b_plus, b_minus, ab_plus, ab_minus, unknown FROM overall_results where year = {$this->getYear()} and edition_type = {$this->getEditionType()}")->fetch(PDO::FETCH_ASSOC);
        $this->actions = $this->pdo->query("SELECT 
                action_days.created_at as day, action_days.start as start, action_days.end as end, action_days.marrow as marrow, 
                places.name as place, schools.short_name as school_short, schools.name as school 
            FROM action_days 
                JOIN places on action_days.place_id = places.id 
                JOIN schools on places.school_id = schools.id 
                JOIN editions on action_days.edition_id = editions.id 
            WHERE editions.number = {$this->getEdition()}
            ORDER BY action_days.created_at")->fetchAll(PDO::FETCH_OBJ);
    }

    public function getData() {
        return $this->results;
    }

    public function getActions() {
        return $this->actions;
    }

    public function getDifference() {
        $edition = $this->getEdition() - 2;

        $result = $this->pdo->query("SELECT overall FROM overall_results where year = {$this->getYear($edition)} and edition_type = {$this->getEditionType($edition)}")->fetch(PDO::FETCH_ASSOC);

        return $this->getData()['overall'] - $result['overall'];
    }

    public function getClass($short_name) {
        return $this->school_mapping[$short_name];
    }
}

