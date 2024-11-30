<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email уведомления
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете включить или выключить отправку email уведомлений. Также
    | можно указать получателей этих уведомлений и шаблон, который будет использован
    | для рендеринга содержимого email уведомления.
    |
    */
    'email' => [

        // Включить или выключить email уведомления
        'enabled' => (bool) env('HEALTH_NOTIFIER_EMAIL_ENABLED', false),

        // адрес отправителя
        'from' => env('HEALTH_NOTIFIER_EMAIL_FROM', 'admin@example.ru'),

        // тема письма
        'subject' => env('APP_NAME') . ' App Health Notification',

        // Список email получателей
        'recipients' => env('HEALTH_NOTIFIER_EMAIL_RECIPIENTS', ['admin@example.ru']),

        // Путь к blade-markdown шаблону для email
        'markdown' => env('HEALTH_NOTIFIER_EMAIL_TEMPLATE', 'health-notifier::mail.notification'),

        // mailer из конфига laravel
        'mailer' => env('HEALTH_NOTIFIER_EMAIL_MAILER', 'smtp'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Telegram уведомления
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете включить или выключить отправку уведомлений в Telegram. 
    | Также необходимо указать токен вашего бота и chat_id для отправки сообщений.
    |
    */
    'telegram' => [

        // Включить или выключить Telegram уведомления
        'enabled' => (bool) env('HEALTH_NOTIFIER_TELEGRAM_ENABLED', false),

        // Chat ID для отправки уведомлений
        'chat_id' => env('HEALTH_NOTIFIER_TELEGRAM_CHAT_ID', 'your-telegram-chat-id'),

        // Токен Telegram-бота
        'bot_token' => env('HEALTH_NOTIFIER_TELEGRAM_BOT_TOKEN', 'your-bot-token')
    ]
];
