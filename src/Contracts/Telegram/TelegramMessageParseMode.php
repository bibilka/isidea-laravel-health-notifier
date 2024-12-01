<?php

namespace Isidea\HealthNotifier\Contracts\Telegram;

enum TelegramMessageParseMode: string
{
    case Markdown = 'Markdown';
    case HTML = 'HTML';
}