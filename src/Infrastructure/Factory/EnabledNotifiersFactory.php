<?php

namespace Isidea\HealthNotifier\Infrastructure\Factory;

use Illuminate\Support\Facades\App;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;
use Isidea\HealthNotifier\Contracts\NotifierCollection;
use Isidea\HealthNotifier\Contracts\NotifierFactory;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramNotificationSettingsRepository;
use Isidea\HealthNotifier\Modules\Email\Adapter\EmailNotifier;
use Isidea\HealthNotifier\Modules\Telegram\Adapter\TelegramBotNotifier;

/**
 * Получение классов-уведомителей.
 */
class EnabledNotifiersFactory implements NotifierFactory
{
    public function __construct(
        private EmailNotificationSettingsRepository $emailNotificationSettings,
        private TelegramNotificationSettingsRepository $telegramNotificationSettings
    ) {}

    /**
     * @inheritdoc
     */
    public function get(): NotifierCollection
    {
        $notifiers = new NotifierCollection;

        if ($this->emailNotificationSettings->isEmailNotificationsEnabled()) {
            $notifiers->add(App::make(EmailNotifier::class));
        }

        if ($this->telegramNotificationSettings->isTelegramNotificationsEnabled()) {
            $notifiers->add(App::make(TelegramBotNotifier::class));
        }

        return $notifiers;
    }
}