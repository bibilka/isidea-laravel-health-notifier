<?php

namespace Isidea\HealthNotifier\Contracts\Logging;

/**
 * Логирование информации.
 */
interface Logger
{
    /**
     * @param string $message
     * @param array $context
     */
    public function info(string $message, array $context = []) : void;
}