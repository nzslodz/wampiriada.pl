<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Core\Mailing\MailingManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->singleton(MailingManager::class, function(){
            return new MailingManager;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
