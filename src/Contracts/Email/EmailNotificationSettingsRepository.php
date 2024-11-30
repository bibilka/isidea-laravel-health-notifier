<?php

namespace Isidea\HealthNotifier\Contracts\Email;

/**
 * Настройки email уведомлений.
 */
interface EmailNotificationSettingsRepository
{
    /**
     * @return bool
     */
    public function isEmailNotificationsEnabled() : bool;

    /**
     * @return array
     */
    public function getRecipients() : array;

    /**
     * @return string|null
     */
    public function getEmailFrom() : ?string;

    /**
     * @return string
     */
    public function getSubject() : string;

    /**
     * @return string|null
     */
    public function getMarkdownTemplate() : ?string;

    /**
     * @return string
     */
    public function getMailer() : string;
}