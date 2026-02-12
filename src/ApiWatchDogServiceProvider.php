<?php

namespace Enescode\ApiWatchdog;

use Illuminate\Support\ServiceProvider;

class ApiWatchdogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/api-watchdog.php', 'api-watchdog');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/api-watchdog.php' => config_path('api-watchdog.php'),
            ], 'api-watchdog-config');
        }

        if ($this->app->runningInConsole()) {
        $this->commands([
            Commands\WatchdogCheckCommand::class,
        ]);
        }
    }
}