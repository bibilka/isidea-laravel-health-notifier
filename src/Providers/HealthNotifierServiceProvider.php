<?php

namespace Isidea\HealthNotifier\Providers;

use Illuminate\Support\ServiceProvider;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;
use Isidea\HealthNotifier\Contracts\Logging\Logger;
use Isidea\HealthNotifier\Contracts\NotifierFactory;
use Isidea\HealthNotifier\Infrastructure\Console\Commands\SendAppHealthNotification;
use Isidea\HealthNotifier\Infrastructure\Factory\EnabledNotifiersFactory;
use Isidea\HealthNotifier\Modules\Email\Adapter\EmailNotificationConfigSettingsRepository;
use Isidea\HealthNotifier\Modules\Logging\Adapter\ModuleLoggingChannelLogger;

class HealthNotifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Публикация конфигурации
        $this->publishes([
            __DIR__ . '/../../config/health_notifier.php' => config_path('health_notifier.php'),
        ], 'config');

        // Публикация шаблонов (если они не были опубликованы)
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/health_notifier'),
        ], 'views');

        // Загрузка представлений с правильным префиксом
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'health_notifier');

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
            return $app->make(ModuleLoggingChannelLogger::class);
        });

        $this->app->singleton(EmailNotificationSettingsRepository::class, function ($app) {
            return new EmailNotificationConfigSettingsRepository();
        });

        $this->app->singleton(NotifierFactory::class, function ($app) {
            return $app->make(EnabledNotifiersFactory::class);
        });

        // config merge
        $this->mergeConfigFrom(
            __DIR__.'/../../config/health_notifier.php', 'health_notifier'
        );
    }
}