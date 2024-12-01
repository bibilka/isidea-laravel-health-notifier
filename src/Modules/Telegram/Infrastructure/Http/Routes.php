<?php

use Illuminate\Support\Facades\Route;
use Isidea\HealthNotifier\Modules\Telegram\Infrastructure\Http\TelegramBotController;

Route::prefix('isidea/health-notifier/telegram-bot')->group(function () {
    Route::post('/webhook', [TelegramBotController::class, 'handleWebhook'])->name('isidea.health-notifier.telegram-bot.webhook');
});