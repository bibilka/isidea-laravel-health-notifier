<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\Commands;

use Illuminate\Http\Request;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBot;

/**
 * Обработка неизвестной команды.
 */
class UnknownCommandHandler
{
    public function __construct(
        private TelegramBot $telegramBot
    ) {}

    /**
     * @param string $chatId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(string $chatId, Request $request) : \Illuminate\Http\JsonResponse
    {
        $message = 'Неизвестная команда';
        $this->telegramBot->sendMessage($chatId, $message);
        return response()->json(['status' => 'OK', 'chat_id' => $chatId, 'message' => $message]);
    }
}