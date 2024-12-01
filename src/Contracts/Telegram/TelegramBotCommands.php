<?php

namespace Isidea\HealthNotifier\Contracts\Telegram;

/**
 * Список команд телеграм бота.
 */
class TelegramBotCommands
{
    /**
     * @var array
     */
    protected array $commands = [];

    /**
     * @param string $command
     * @param string $description
     * @return self
     */
    public function addCommand(string $command, string $description) : self
    {
        $this->commands[$command] = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function get() : array
    {
        return $this->commands;
    }
}