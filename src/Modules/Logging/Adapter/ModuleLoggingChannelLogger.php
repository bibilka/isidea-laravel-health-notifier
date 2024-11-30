<?php

namespace Isidea\HealthNotifier\Modules\Logging\Adapter;

use Illuminate\Support\Facades\Log;
use Isidea\HealthNotifier\Contracts\Logging\Logger;

/**
 * @inheritdoc
 */
class ModuleLoggingChannelLogger implements Logger
{
    /**
     * @inheritdoc
     */
    public function info(string $message, array $context = []) : void
    {
        Log::channel('health_notifier')->info($message, $context);
    }
}