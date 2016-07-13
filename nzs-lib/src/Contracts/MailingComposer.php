<?php namespace NZS\Core\Contracts;
use App\User;

interface MailingComposer {
    public function getView();
    public function getSubject(User $user);
    public function getContext(User $user);

    public function getCampaignKey();
    public function getCampaignName();

    public function getJobInstance(User $user);

    public static function spawnSampleInstance();
    public function getSampleContext(User $user);

}
