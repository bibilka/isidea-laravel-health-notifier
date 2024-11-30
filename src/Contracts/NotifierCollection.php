<?php

namespace Isidea\HealthNotifier\Contracts;

/**
 * Список классов-уведомителей.
 */
class NotifierCollection
{
    /**
     * @var Notifier[]|array
     */
    public array $notifiers = [];

    /**
     * @param array $notifiers
     */
    public function __construct(array $notifiers = [])
    {
        foreach ($notifiers as $notifier) {
            if ($notifier instanceof Notifier) {
                $this->add($notifier);
            }
        }
    }

    /**
     * @param Notifier $notifier
     * @return self
     */
    public function add(Notifier $notifier) : self
    {
        $this->notifiers[] = $notifier;
        return $this;
    }

    /**
     * @return Notifier[]|array
     */
    public function getNotifiers() : array
    {
        return $this->notifiers;
    }
}