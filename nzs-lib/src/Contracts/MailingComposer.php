<?php namespace NZS\Core\Contracts;
use NZS\Core\Person;

interface MailingComposer {
    public function getView();
    public function getSubject(Person $user);
    public function getContext(Person $user);

    public function getCampaignKey();
    public function getCampaignName();

    public function getJobInstance(Person $user);

    public static function spawnSampleInstance();
    public function getSampleContext(Person $user);

}
