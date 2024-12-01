<?php

namespace Isidea\HealthNotifier\Modules\Logging\Providers;

use Illuminate\Support\ServiceProvider;
use Isidea\HealthNotifier\Contracts\Logging\Logger;
use Isidea\HealthNotifier\Modules\Logging\Adapter\ModuleLoggingChannelLogger;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Logger::class, function ($app) {
            return $app->make(ModuleLoggingChannelLogger::class);
        });
    }
}