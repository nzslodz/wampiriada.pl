<?php namespace NZS\Wampiriada;

use NZS\Core\ActivityContainer;
use NZS\Core\RequiresActivityContainer;
use NZS\Core\Contracts\Timeline;

class EmailCampaignResultTimeline implements Timeline {
    use RequiresActivityContainer;

    public function convertToTimelineObject() {
        $data = $this->getActivityContainer();

        if(ends_with($data->redirect->url, '.jpg') || ends_with($data->redirect->url, '.png')) {
            $headline = "Przeczytanie e-maila: {$data->email_campaign->name}";
            $title = "(Jest to moment załadowania e-maila do czytania)";
        } else {
            $headline = "Kliknięcie: {$data->email_campaign->name}";
            $title = "Kliknięty link: {$data->redirect->url} <a href=\"{$data->redirect->url}\">{$data->redirect->key}</a>.";
        }

        return [
            'start_date' => [
                'month' => $data->email_campaign_result->created_at->format('m'),
                'year' => $data->email_campaign_result->created_at->format('Y'),
                'day' => $data->email_campaign_result->created_at->format('d'),
                'hour' => $data->email_campaign_result->created_at->format('H'),
                'minute' => $data->email_campaign_result->created_at->format('i'),
                'second' => $data->email_campaign_result->created_at->format('s')
            ],
            'group' => 'Clicktracking',
            'unique_id' => $data->activity->id,
            'text' => [
                'headline' => $headline,
                'text' => $title,
            ],
        ];
    }

}
