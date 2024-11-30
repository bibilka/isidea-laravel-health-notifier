<?php

namespace Isidea\HealthNotifier\Contracts;

/**
 * Отправитель уведомлений.
 */
interface Notifier
{
    /**
     * @throws \Exception
     * @return bool
     */
    public function notify() : bool;
}