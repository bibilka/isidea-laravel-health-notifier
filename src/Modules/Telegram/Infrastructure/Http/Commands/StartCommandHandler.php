<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\Commands;

use Illuminate\Http\Request;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBot;

/**
 * Обработка команды /start.
 */
class StartCommandHandler
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
        $this->telegramBot->sendMessage($chatId, "Chat ID: {$chatId}");
        return response()->json(['status' => 'OK', 'chat_id' => $chatId]);
    }
}