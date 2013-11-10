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

    public function __construct($edition) {
        $this->pdo = include __DIR__ . '/db.php';
        $this->results = $this->pdo->query('SELECT overall, zero_plus, zero_minus, a_plus, a_minus, b_plus, b_minus, ab_plus, ab_minus, unknown FROM overall_results where year = "2013" and edition_type = "1"')->fetch(PDO::FETCH_ASSOC);
        $this->actions = $this->pdo->query("SELECT 
                action_days.created_at as day, action_days.start as start, action_days.end as end, action_days.marrow as marrow, 
                place.name as place, school.short_name as school_short, school.name as school 
            FROM action_days 
                JOIN places on action_days.place_id = places.id 
                JOIN schools on places.school_id = schools.id 
                JOIN editions on action_days.edition_id = editions.id 
            WHERE edtions.number = $edition
            ORDER BY action_days.created_at")->fetch(PDO::FETCH_ASSOC);
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

