<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResultActivityClass;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use NZS\Core\ActivityRepository;
use NZS\Core\DatabaseActivityRepository;
use NZS\Core\Mailing\MailingRepository;

class MailingServiceProvider extends ServiceProvider
{


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MailingRepository::class, function($app) {
            return new MailingRepository;
        });

        $this->app->singleton(MailingManager::class, function(){
            return new MailingManager;
        });
    }
}
