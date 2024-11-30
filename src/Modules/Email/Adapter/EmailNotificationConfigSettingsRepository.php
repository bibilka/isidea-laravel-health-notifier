<?php

namespace Isidea\HealthNotifier\Modules\Email\Adapter;

use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;

class EmailNotificationConfigSettingsRepository implements EmailNotificationSettingsRepository
{
    /**
     * @return bool
     */
    public function isEmailNotificationsEnabled() : bool
    {
        return (bool) config('health_notifier.email.enabled', false);
    }

    /**
     * @return array
     */
    public function getRecipients() : array
    {
        return config('health_notifier.email.recipients', []);
    }

    /**
     * @return string|null
     */
    public function getEmailFrom() : ?string
    {
        return config('health_notifier.email.from');
    }

    /**
     * @return string
     */
    public function getSubject() : string
    {
       return config('health_notifier.email.subject', config('app.name') . ' App Health Notification');
    }

    /**
     * @return string|null
     */
    public function getMarkdownTemplate(): ?string
    {
        return config('health_notifier.email.markdown');
    }

    /**
     * @return string
     */
    public function getMailer(): string
    {
        return config('health_notifier.email.mailer', 'smtp');
    }
}