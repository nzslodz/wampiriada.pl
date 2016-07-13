<?php namespace NZS\Core\Mailing;
use NZS\Core\Contracts\MailingComposer;
use App\User;

abstract class BaseMailingComposer implements MailingComposer {
    protected $view;
    protected $subject;

    protected $campaign_key;
    protected $campaign_name;

    protected $job_class;

    public function getView() {
        return $this->view;
    }

    public function getSubject(User $user) {
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

    public function getJobInstance(User $user) {
        $class_name = $this->job_class;

        return new $class_name($user);
    }

    public function getSampleContext(User $user) {
        return [
            'user' => $user,
            'composer' => $this,
        ];
    }
}
