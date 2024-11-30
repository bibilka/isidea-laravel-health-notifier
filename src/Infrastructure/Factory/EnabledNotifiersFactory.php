<?php

namespace Isidea\HealthNotifier\Infrastructure\Factory;

use Illuminate\Support\Facades\App;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;
use Isidea\HealthNotifier\Contracts\NotifierCollection;
use Isidea\HealthNotifier\Contracts\NotifierFactory;
use Isidea\HealthNotifier\Modules\Email\Adapter\EmailNotifier;

/**
 * Получение классов-уведомителей.
 */
class EnabledNotifiersFactory implements NotifierFactory
{
    public function __construct(
        private EmailNotificationSettingsRepository $emailNotificationSettings
    ) {}

    /**
     * @inheritdoc
     */
    public function get(): NotifierCollection
    {
        $notifiers = new NotifierCollection;

        if ($this->emailNotificationSettings->isEmailNotificationsEnabled()) {
            $notifiers[] = App::make(EmailNotifier::class);
        }

        return $notifiers;
    }
}