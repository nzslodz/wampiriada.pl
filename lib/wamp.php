<?php 

class Wamp {
    protected $pdo, $results, $actions;

    protected $school_mapping = array(
        'UŁ' => 'ul',
        'PŁ' => 'pl',
        'UMed' => 'um',
        'WSInfiU' => 'wsinf',
        'AHE' => 'ahe',
        'Pozostałe' => 'other',
    );

    protected function getEditionType($edition) {
        return $edition % 2 + 1;
    }

    protected function getYear($edition) {
        return (int) ($edition / 2) + 1992;
    }

    public function __construct($edition) {
        $this->pdo = include __DIR__ . '/db.php';

        echo $this->getYear($edition);
        echo $this->getEditionType($edition);

        $this->results = $this->pdo->query("SELECT overall, zero_plus, zero_minus, a_plus, a_minus, b_plus, b_minus, ab_plus, ab_minus, unknown FROM overall_results where year = {$this->getYear($edition)} and edition_type = {$this->getEditionType($edition)}")->fetch(PDO::FETCH_ASSOC);
        $this->actions = $this->pdo->query("SELECT 
                action_days.created_at as day, action_days.start as start, action_days.end as end, action_days.marrow as marrow, 
                places.name as place, schools.short_name as school_short, schools.name as school 
            FROM action_days 
                JOIN places on action_days.place_id = places.id 
                JOIN schools on places.school_id = schools.id 
                JOIN editions on action_days.edition_id = editions.id 
            WHERE editions.number = $edition
            ORDER BY action_days.created_at")->fetchAll(PDO::FETCH_OBJ);
    }

    public function getData() {
        return $this->results;
    }

    public function getActions() {
        return $this->actions;
    }

    public function getClass($short_name) {
        return $this->school_mapping[$short_name];
    }
}

