<?php namespace NZS\Core\Mailing;
use NZS\Core\Contracts\MailingComposer;
use NZS\Core\Mailing\SimpleEmailJob;

abstract class BaseMailingComposer implements MailingComposer {
    protected $view;
    protected $subject;

    protected $campaign_key;
    protected $campaign_name;

    protected $job_class = SimpleEmailJob::class;

    public function getView() {
        return $this->view;
    }

    public function getSubject($user) {
        return $this->subject;
    }

    public function getCampaignKey() {
        return $this->campaign_key;
    }

    public function getCampaignName() {
        return $this->campaign_name;
    }

    public static function spawnSampleInstance() {
        return new static;
    }

    public function getJobInstance($user) {
        $class_name = $this->job_class;

        return new $class_name($user, get_class($this));
    }

    public function getSampleContext($user) {
        return $this->getContext($user);
    }
}
