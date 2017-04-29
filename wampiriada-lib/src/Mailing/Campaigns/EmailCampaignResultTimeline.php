<?php namespace NZS\Wampiriada\Mailing\Campaigns;

use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Core\TimelineTrait;

class EmailCampaignResultTimeline implements Timeline {
    use TimelineTrait;
    protected $container;

    public function __construct(ActivityContainer $container) {
        $this->container = $container;
    }

    public function convertToTimelineObject() {
        $data = $this->container;

        if(ends_with($data->redirect->url, '.jpg') || ends_with($data->redirect->url, '.png')) {
            $headline = "Przeczytanie e-maila: {$data->email_campaign->name}";
            $title = "(Jest to moment załadowania e-maila do czytania)";
        } else {
            $headline = "Kliknięcie: {$data->email_campaign->name}";
            $title = "Kliknięty link: {$data->redirect->url} <a href=\"{$data->redirect->url}\">{$data->redirect->key}</a>.";
        }

        return [
            'start_date' => $this->convertToTimestampObject($data->object->created_at),
            'group' => 'Clicktracking',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => $headline,
                'text' => $title,
            ],
        ];
    }

}
