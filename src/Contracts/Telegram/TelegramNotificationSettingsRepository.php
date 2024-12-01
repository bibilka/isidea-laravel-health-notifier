<?php

namespace Isidea\HealthNotifier\Contracts\Telegram;

/**
 * Настройки telegram уведомлений.
 */
interface TelegramNotificationSettingsRepository
{
    /**
     * @return string|null
     */
    public function getBotToken() : ?string;

    /**
     * @return string|null
     */
    public function getChatId() : ?string;

    /**
     * @return bool
     */
    public function isTelegramNotificationsEnabled() : bool;

    /**
     * @return string
     */
    public function getTemplate() : string;
}