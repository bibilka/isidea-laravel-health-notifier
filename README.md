# Health Notifier

**Health Notifier** — это пакет для Laravel, который позволяет отправлять уведомления о состоянии работоспособности вашего приложения. Пакет поддерживает уведомления через несколько каналов, таких как **email** и **Telegram**.

## Возможности
- **Email уведомления**: Отправка уведомлений о состоянии приложения на несколько email-адресов.
- **Telegram уведомления**: Отправка уведомлений в указанный Telegram-чат.

## Установка

Чтобы установить **Health Notifier** в ваше приложение на Laravel, используйте composer:


```bash
composer require isidea/health-notifier
```

**После установки пакета, опубликуйте конфигурацию с помощью команды:**

```bash
php artisan vendor:publish --provider="Isidea\HealthNotifier\Providers\HealthNotifierServiceProvider" --tag="config"
```

Перейдите в файл конфигурации `config/health-notifier.php` и настройте необходимые параметры.

## Регистрация команды отправки уведомлений

Уведомления отправляются при помощи команды `SendAppHealthNofication`. Зарегистрируйте ее в качестве регулярной задачи любым удобным способом.

### Laravel Scheduler

Добавьте команду в ваш `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('health-notifier:notify')->everyMinute();
}
```

Убедитесь, что cron работает на вашем сервере. Пример cron задания:

```cron
0 0 * * * /path-to-php/php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

### Cron напрямую

```cron
0 0 * * * /path-to-php/php /path-to-your-project/artisan health-notifier:notify --no-interaction >> /dev/null 2>&1
```

## Настройки Email уведомлений

```php
    'email' => [

        // Включить или выключить email уведомления
        'enabled' => (bool) env('HEALTH_NOTIFIER_EMAIL_ENABLED', true),

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
```

Можно изменить/дополнить/расширить шаблон письма, который используется по-умолчанию:
```bash
php artisan vendor:publish --provider="Isidea\HealthNotifier\Providers\HealthNotifierServiceProvider" --tag="views"
```

## Настройки Telegram уведомлений

```php
    'telegram' => [

        // Включить или выключить Telegram уведомления
        'enabled' => (bool) env('HEALTH_NOTIFIER_TELEGRAM_ENABLED', false),

        // Chat ID для отправки уведомлений
        'chat_id' => env('HEALTH_NOTIFIER_TELEGRAM_CHAT_ID', 'your-telegram-chat-id'),

        // Токен Telegram-бота
        'bot_token' => env('HEALTH_NOTIFIER_TELEGRAM_BOT_TOKEN', 'your-bot-token')
    ]
```

