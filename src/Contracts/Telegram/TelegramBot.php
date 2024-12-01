<?php

namespace Isidea\HealthNotifier\Contracts\Telegram;

/**
 * Телеграм бот.
 */
interface TelegramBot
{
    /**
     * @return array Обновления бота
     */
    public function getUpdates() : array;

    /**
     * Отправить сообщение от бота.
     * @param string $chatId
     * @param string $message
     * @param TelegramMessageParseMode $parseMode
     * @return array
     */
    public function sendMessage(string $chatId, string $message, TelegramMessageParseMode $parseMode) : array;

    /**
     * Установить боту вебхук обработчик.
     * @param string $webhookUrl
     * @return array
     */
    public function setWebhook(string $webhookUrl) : array;

    /**
     * @param TelegramBotCommands $commands
     * @return array
     */
    public function setCommands(TelegramBotCommands $commands) : array;
}