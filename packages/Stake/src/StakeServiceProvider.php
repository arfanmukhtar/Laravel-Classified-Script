<?php

namespace Laravelclassified\Stake;

use Illuminate\Support\ServiceProvider;

class StakeServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        // Register your package's services or bindings here.
    }

    public function boot()
    {
        // if ($this->app->runningInConsole()) {
        //     $this->commands();
        // }

        // Bootstrap your package here (e.g., routes, views, assets).
            
        $this->loadRoutesFrom(__DIR__.'/Two/web.php');

        $this->loadViewsFrom(__DIR__.'/Three/html', 'posts');

    }
}