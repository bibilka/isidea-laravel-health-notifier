<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Adapter;

use Isidea\HealthNotifier\Contracts\Logging\Logger;
use Isidea\HealthNotifier\Contracts\Notifier;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBot;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramNotificationSettingsRepository;
use Illuminate\Support\Facades\View;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramMessageParseMode;

/**
 * Уведомитель в телеграм чат.
 */
class TelegramBotNotifier implements Notifier
{
    public function __construct(
        private TelegramBot $telegramBot,
        private TelegramNotificationSettingsRepository $settings,
        private Logger $logger
    ) {}

    /**
     * @return bool
     */
    public function notify() : bool
    {
        try {
            if (!$this->settings->isTelegramNotificationsEnabled()) return false;

            $this->logger->info('Отправка уведомления в телеграм чат...');

            $chatId = $this->settings->getChatId();
            if (!$chatId) {
                throw new \Exception('Не указан Chat ID для отправки уведомления');
            }

            $message = View::make($this->settings->getTemplate())->render();
            $this->telegramBot->sendMessage($chatId, $message, TelegramMessageParseMode::HTML);

            $this->logger->info('Отправка уведомления в телеграм чат прошла успешно');

            return true;

        } catch (\Exception $ex) {

            $this->logger->info("Ошибка при отправке уведомления в телеграм чат: {$ex->getMessage()}");
            return false;
        }
    }
}