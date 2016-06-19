<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Wampiriada\EmailCampaignResultActivityClass;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use NZS\Core\ActivityRepository;
use NZS\Core\DatabaseActivityRepository;
use NZS\Wampiriada\CheckinActivityClass;
use NZS\Wampiriada\PrizeForCheckinActivityClass;

class ActivityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $repository = $this->app[ActivityRepository::class];
        $repository->append($this->app->tagged('activity.model_classes'));
        $repository->registerActivityEvents();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ActivityRepository::class, function($app) {
            return new DatabaseActivityRepository($app['migration.repository']);
        });

        $this->app->tag([
            CheckinActivityClass::class,
            EmailCampaignResultActivityClass::class,
            PrizeForCheckinActivityClass::class,
        ], 'activity.model_classes');
    }
}