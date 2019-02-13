<?php

namespace RevoSystems\iOSPassKit;

use Illuminate\Support\ServiceProvider;

class iOSPassKitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../config/passKit.php' => config_path('passKit.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/passKit.php', 'passKit');
        app()->singleton(ResourceManager::class, function () {
            return new ResourceManager();
        });
    }

    public function provides()
    {
        return ResourceManager::class;
    }
}
