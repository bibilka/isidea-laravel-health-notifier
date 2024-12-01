<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Isidea\HealthNotifier\Contracts\Logging\Logger;
use Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\Commands\StartCommandHandler;
use Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\Commands\UnknownCommandHandler;

/**
 * Обработка команд от телеграм бота.
 */
class TelegramBotController extends Controller
{
    public function __construct(
        private Logger $logger
    ) {}

    /**
     * @var array
     */
    protected array $commandHandlers = [
        '/start' => StartCommandHandler::class,
    ];

    /**
     * Обработка входящих запросов от Telegram (Webhook).
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleWebhook(Request $request) : \Illuminate\Http\JsonResponse
    {
        $this->logger->info('Обработка вебхука ТГ бота', $request->input());

        // Получаем данные из запроса
        $chatId = $request->input('message.chat.id');
        if (!$chatId) {
            return response()->json(['status' => 'No chat ID found'], 400);
        }

        // Проверяем, есть ли сообщение и текст
        if ($message = $request->input('message.text')) {

            // Проверяем, есть ли обработчик для этой команды
            if (isset($this->commandHandlers[$message])) {
                $handlerClass = $this->commandHandlers[$message];

                // Создаем обработчик и вызываем его
                $handler = App::make($handlerClass);
                return $handler->handle($chatId, $request);
            }

            // Если команды нет в маппинге, отправляем сообщение о неизвестной команде
            return App::make(UnknownCommandHandler::class)->handle($chatId, $request);
        }

        return response()->json(['status' => 'OK']);
    }
}