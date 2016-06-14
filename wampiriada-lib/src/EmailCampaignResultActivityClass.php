<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Wampiriada\EmailCampaignResult;
use NZS\Wampiriada\EmailCampaignResultTimeline;
use NZS\Core\Contracts\Timeline;

class EmailCampaignResultActivityClass extends ActivityClass {
    public function getModel() {
        return EmailCampaignResult::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return EmailCampaignResultTimeline::class;
        }
    }

    public function loadData(Activity $activity) {
        $container = new ActivityContainer($activity);

        $container->email_campaign_result = EmailCampaignResult::whereActivityId($activity->id)->first();
        $container->email_campaign = $container->email_campaign_result->campaign;
        $container->redirect = $container->email_campaign_result->redirect;

        return $container;
    }
}
