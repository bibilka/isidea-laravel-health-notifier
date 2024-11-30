<?php

namespace Isidea\HealthNotifier\Modules\Logging\Adapter;

use Isidea\HealthNotifier\Contracts\Logging\Logger;

/**
 * @inheritdoc
 */
class ModuleLoggingChannelLogger implements Logger
{
    public function __construct(
        private RotatingLoggerFactory $factory
    ) {}

    /**
     * @inheritdoc
     */
    public function info(string $message, array $context = []) : void
    {
        $this->factory->get('health_notifier')->info($message, $context);
    }
}