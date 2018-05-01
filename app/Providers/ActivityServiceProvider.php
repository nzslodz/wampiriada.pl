<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResultActivityClass;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use NZS\Core\ActivityRepository;
use NZS\Core\DatabaseActivityRepository;
use NZS\Core\HR\AttendanceActivityClass;
use NZS\Wampiriada\Reminders\ReminderActivityClass;

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
            EmailCampaignResultActivityClass::class,
            AttendanceActivityClass::class,
        ], 'activity.model_classes');
    }
}
