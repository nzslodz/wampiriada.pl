<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityClass;

class EmailCampaignResultActivityClass extends ActivityClass {
    public function getModel() {
        return EmailCampaignResult::class;
    }
}
