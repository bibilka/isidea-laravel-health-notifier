<?php

namespace Isidea\HealthNotifier\Modules\Email\Providers;

use Illuminate\Support\ServiceProvider;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;
use Isidea\HealthNotifier\Modules\Email\Adapter\EmailNotificationConfigSettingsRepository;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EmailNotificationSettingsRepository::class, function ($app) {
            return new EmailNotificationConfigSettingsRepository();
        });
    }
}