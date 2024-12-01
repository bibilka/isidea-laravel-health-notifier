<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Providers;

use Illuminate\Support\ServiceProvider;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBot;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramNotificationSettingsRepository;
use Isidea\HealthNotifier\Modules\Telegram\Adapter\TelegramNotificationConfigSettingsRepository;
use Isidea\HealthNotifier\Modules\Telegram\Client\TelegramBotHttpClient;
use Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Console\Commands\TelegramBotSetWeebhook;
use Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\Commands\StartCommandHandler;
use Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\Commands\UnknownCommandHandler;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        // Загружаем маршруты
        $this->loadRoutesFrom(__DIR__.'/../Infrastructure/Http/Routes.php');

        $this->commands([
            TelegramBotSetWeebhook::class
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TelegramNotificationSettingsRepository::class, function ($app) {
            return new TelegramNotificationConfigSettingsRepository;
        });

        $this->app->singleton(TelegramBot::class, function ($app) {
            return new TelegramBotHttpClient(
                $app->make(TelegramNotificationSettingsRepository::class)->getBotToken()
            );
        });

        $this->app->singleton(StartCommandHandler::class, StartCommandHandler::class);

        $this->app->singleton(UnknownCommandHandler::class, UnknownCommandHandler::class);
    }
}