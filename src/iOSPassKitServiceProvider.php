<?php

namespace RevoSystems\iOSPassKit;

use Illuminate\Support\ServiceProvider;

class iOSPassKitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__.'/../config/passKit.php' => config_path('passKit.php')
        ], 'config');
    }

    public function register()
    {
        app()->singleton(ResourceManager::class, function () {
            return new ResourceManager();
        });
    }

    public function provides()
    {
        return ResourceManager::class;
    }
}
