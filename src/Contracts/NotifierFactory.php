<?php

namespace Isidea\HealthNotifier\Contracts;

/**
 * Получение классов-уведомителей.
 */
interface NotifierFactory
{
    /**
     * @return NotifierCollection
     */
    public function get() : NotifierCollection;
}