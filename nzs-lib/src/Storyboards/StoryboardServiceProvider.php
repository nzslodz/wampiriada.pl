<?php namespace NZS\Core\Storyboards;

use Illuminate\Support\ServiceProvider;
use NZS\Core\Storyboards\StoryboardManager;


class StoryboardServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton('storyboard', function() {
            return $this->app->make(StoryboardManager::class);
        });
    }
}
