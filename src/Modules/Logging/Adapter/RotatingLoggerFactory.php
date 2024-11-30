<?php

namespace Isidea\HealthNotifier\Modules\Logging\Adapter;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

/**
 * Класс фактори для создания объектов типа "лог с ротацией".
 */
class RotatingLoggerFactory
{
    /**
     * @param string $name
     * @return \Psr\Log\LoggerInterface
     */
    public function get(string $name) : \Psr\Log\LoggerInterface
    {
        // Определяем настройки логирования
        $loggerName = $name;
        $logPath = storage_path('logs/' . $name . '.log');
        $logLevel = env('LOG_LEVEL', 'debug'); // Получаем уровень логирования из переменной окружения
        $daysToKeep = 14; // Количество дней хранения логов

        // Создаем логгер
        $logger = new Logger($loggerName);

        // Настраиваем обработчик для ежедневного логирования с ротацией файлов
        $handler = new RotatingFileHandler($logPath, $daysToKeep, $logLevel);
        $handler->setFormatter(new LineFormatter(null, 'Y-m-d H:i:s', true, true));

        // Добавляем обработчик в логгер
        $logger->pushHandler($handler);

        return $logger;
    }
}