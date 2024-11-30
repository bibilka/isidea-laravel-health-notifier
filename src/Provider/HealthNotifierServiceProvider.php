<?php

namespace Isidea\HealthNotifier\Provider;

use Illuminate\Support\ServiceProvider;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;
use Isidea\HealthNotifier\Contracts\Logging\Logger;
use Isidea\HealthNotifier\Infrastructure\Console\Commands\SendAppHealthNotification;
use Isidea\HealthNotifier\Modules\Email\Adapter\EmailNotificationConfigSettingsRepository;
use Isidea\HealthNotifier\Modules\Logging\Adapter\ModuleLoggingChannelLogger;

class HealthNotifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // config
        $this->publishes([
            __DIR__ . '/../config/health_notifier.php' => config_path('health_notifier.php'),
        ]);

        // views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'health_notifier');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/health_notifier'),
        ]);

        // Регистрируем команду
        $this->commands([
            SendAppHealthNotification::class
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // contracts and adapters

        $this->app->singleton(Logger::class, function ($app) {
            return new ModuleLoggingChannelLogger();
        });

        $this->app->singleton(EmailNotificationSettingsRepository::class, function ($app) {
            return new EmailNotificationConfigSettingsRepository();
        });

        // config merge
        $this->mergeConfigFrom(
            __DIR__.'/../config/health_notifier.php', 'health_notifier'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/../config/logging.php', 'logging'
        );
    }
}