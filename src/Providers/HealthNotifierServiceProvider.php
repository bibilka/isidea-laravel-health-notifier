<?php

namespace Isidea\HealthNotifier\Providers;

use Illuminate\Support\ServiceProvider;
use Isidea\HealthNotifier\Contracts\NotifierFactory;
use Isidea\HealthNotifier\Infrastructure\Console\Commands\SendAppHealthNotification;
use Isidea\HealthNotifier\Infrastructure\Factory\EnabledNotifiersFactory;
use Isidea\HealthNotifier\Modules\Email\Providers\EmailServiceProvider;
use Isidea\HealthNotifier\Modules\Logging\Providers\LoggingServiceProvider;
use Isidea\HealthNotifier\Modules\Telegram\Providers\TelegramServiceProvider;

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
        // modules providers
        $this->app->register(TelegramServiceProvider::class);
        $this->app->register(EmailServiceProvider::class);
        $this->app->register(LoggingServiceProvider::class);

        // common contracts and adapters
        $this->app->singleton(NotifierFactory::class, function ($app) {
            return $app->make(EnabledNotifiersFactory::class);
        });

        // config merge
        $this->mergeConfigFrom(
            __DIR__.'/../../config/health_notifier.php', 'health_notifier'
        );
    }
}