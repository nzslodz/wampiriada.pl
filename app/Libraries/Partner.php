<?php namespace App\Libraries;

class Partner {
    public
        $url = null,
        $image = null,
        $title = null;
    
    public function __construct($partner_def, $key) {
        if(isset($partner_def['image'])) {
            $this->image = $partner_def['image'];
        }

        if(isset($partner_def['title'])) {
            $this->title = str_replace('%s', $key, $partner_def['title']);
        }

        if(isset($partner_def['link'])) {
            $this->url = $partner_def['link'];
        }
    }
}
