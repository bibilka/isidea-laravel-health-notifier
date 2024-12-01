<?php

namespace Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBot;
use Isidea\HealthNotifier\Contracts\Telegram\TelegramBotCommands;

/**
 * Устанавливает текущее приложение в качестве обработчика вебхука ТГ бота
 */
class TelegramBotSetWeebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health-notifier:telegram-bot-set-weebhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Устанавливает текущее приложение в качестве обработчика вебхука ТГ бота';

    public function __construct(
        private TelegramBot $telegramBot
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Установить текущее приложение в качестве обработчика вебхука телеграм бота?')) {

            $this->telegramBot->setWebhook(
                route('isidea.health-notifier.telegram-bot.webhook')
            );

            $this->telegramBot->setCommands(
                (new TelegramBotCommands)->addCommand('/start', 'Инициализация бота')
            );

            $this->info('Успешно');
        }
    }
}
