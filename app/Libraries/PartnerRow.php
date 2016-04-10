<?php namespace App\Libraries;

class PartnerRow {
    protected
        $partners,
        $structure,
        $unknown;

    public function __construct($partners, $row_structure, $unknown) {
        $this->partners = $partners;
        $this->structure = $row_structure;
        $this->unknown = $unknown;
    }

    public function getPartners() {
        foreach($this->structure as $key) {
            if(isset($this->partners[$key])) {
                $partner = new Partner($this->partners[$key], $key);
            } else {
                $partner = new Partner($this->unknown, $key);
            }

            yield $partner;
        }
    }

    public function getCount() {
        return count($this->structure);
    }

}
