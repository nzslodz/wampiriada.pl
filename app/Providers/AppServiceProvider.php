<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Core\Mailing\MailingManager;
use Stevenmaguire\Services\Trello\Client as TrelloClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TrelloClient::class, function($app) {
            return new TrelloClient(array(
    		    'key' => config('app.trello.key'),
    		    'token'  => config('app.trello.token'),
    			//'domain' => 'http://api.trello.com',
    		));
        });
    }
}
