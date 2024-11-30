<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Канал логирования по уведомлениям на email
    |--------------------------------------------------------------------------
    |
    */
    'channels' => [

        'health_notifier' => [
            'driver' => 'daily',
            'path' => storage_path('logs/health_notifier.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => env('LOG_DAILY_DAYS', 14),
            'replace_placeholders' => true,
        ],
    ],
];
