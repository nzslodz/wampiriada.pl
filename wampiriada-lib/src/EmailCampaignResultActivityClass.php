<?php namespace NZS\Wampiriada;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Wampiriada\EmailCampaignResult;
use NZS\Wampiriada\EmailCampaignResultTimeline;
use NZS\Core\Contracts\Timeline;

class EmailCampaignResultActivityClass extends ModelActivityClass {
    public function getModel() {
        return EmailCampaignResult::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return EmailCampaignResultTimeline::class;
        }
    }

    public function loadData(ActivityContainer $container) {
        $container->email_campaign = $container->object->campaign;
        $container->redirect = $container->object->redirect;

        return $container;
    }
}
