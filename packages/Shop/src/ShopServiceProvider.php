<?php

namespace Laravelclassified\Shop;

use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
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
            
        // $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}