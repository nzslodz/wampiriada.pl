<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NZS\Core\Mailing\MailingManager;
use Stevenmaguire\Services\Trello\Client as TrelloClient;
use GuzzleHttp\Client;

use Carbon\Carbon;

use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('recaptcha', 'NZS\Core\Utils\Recaptcha@validate');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TrelloClient::class, function($app) {
            $trello = new TrelloClient(array(
    		    'key' => config('services.trello.key'),
    		    'token'  => config('services.trello.token'),
    			//'domain' => 'http://api.trello.com',
    		));

            $trello->setHttpClient(new Client(['verify' => false]));

            return $trello;
        });

        // XXX app()->getLocale() ?
        Carbon::setLocale('pl');
    }
}
