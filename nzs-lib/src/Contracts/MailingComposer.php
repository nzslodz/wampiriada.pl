<?php namespace NZS\Core\Contracts;

interface MailingComposer {
    public function getView();
    public function getSubject($user);
    public function getContext($user);

    public function getCampaignKey();
    public function getCampaignName();

    public function getJobInstance($user);

    public static function spawnSampleInstance();
    public function getSampleContext($user);

}
