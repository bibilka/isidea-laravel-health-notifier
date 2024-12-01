<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Client;

use Illuminate\Support\Facades\Http;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBot;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBotCommands;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramMessageParseMode;

/**
 * Класс-клиент для взаимодействия с API телеграм ботов.
 */
class TelegramBotHttpClient implements TelegramBot
{
    /**
     * @var string $url
     */
    protected string $url;

    /**
     * @param string $token
     * @return void
     */
    public function __construct(string $token)
    {
        $this->url = "https://api.telegram.org/bot{$token}";
    }

    /**
     * Получить обновления.
     * 
     * @throws \Illuminate\Http\Client\RequestException
     * 
     * @return array
     */
    public function getUpdates() : array
    {
        // Отправляем запрос к Telegram API для получения обновлений
        $response = Http::get("{$this->url}/getUpdates");

        $response->throw();

        // Возвращаем результат в виде массива
        return $response->json();
    }

    /**
     * Устанавливает список доступных комманд для бота.
     * @param TelegramBotCommands $commands
     * @return array
     */
    public function setCommands(TelegramBotCommands $commands) : array
    {
        foreach ($commands->get() as $command => $description) {
            $commandsData[] = compact('command', 'description');
        }

        $response = Http::post("{$this->url}/setMyCommands", [
            'commands' => $commandsData,
        ]);

        $response->throw();

        return $response->json();
    }

    /**
     * Отправить сообщение в чат.
     * 
     * @throws \Illuminate\Http\Client\RequestException
     * 
     * @param string $chatId
     * @param string $message
     * @param TelegramMessageParseMode $parseMode
     * 
     * @return array
     */
    public function sendMessage(string $chatId, string $message, TelegramMessageParseMode $parseMode) : array
    {
        // Отправляем запрос к Telegram API для отправки сообщения
        $response = Http::post("{$this->url}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => $parseMode->value,
        ]);

        $response->throw();

        // Возвращаем ответ от API Telegram
        return $response->json();
    }

    /**
     * Устанавливаем webhook для вашего бота
     * 
     * @param string $webhookUrl
     * @return array
     */
    public function setWebhook(string $webhookUrl) : array
    {
        // удаляем вебхук
        Http::post("{$this->url}/setWebhook?remove");

        // Отправляем запрос на установку webhook
        $response = Http::post("{$this->url}/setWebhook", [
            'url' => $webhookUrl
        ]);

        $response->throw();

        // Возвращаем результат
        return $response->json();
    }
}