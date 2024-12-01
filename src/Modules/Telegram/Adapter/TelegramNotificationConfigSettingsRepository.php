<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Adapter;

use Isidea\HealthNotifier\Contracts\Telegram\TelegramNotificationSettingsRepository;

class TelegramNotificationConfigSettingsRepository implements TelegramNotificationSettingsRepository
{
    /**
     * @return string|null
     */
    public function getBotToken() : ?string
    {
        return config('health_notifier.telegram.bot_token');
    }

    /**
     * @return string
     */
    public function getChatId() : string
    {
        return config('health_notifier.telegram.chat_id');
    }

    /**
     * @return bool
     */
    public function isTelegramNotificationsEnabled() : bool
    {
        return (bool) config('health_notifier.telegram.enabled', false);
    }

    /**
     * @return string
     */
    public function getTemplate() : string
    {
        return config('health_notifier.telegram.template', 'health_notifier::telegram.notification');
    }
}