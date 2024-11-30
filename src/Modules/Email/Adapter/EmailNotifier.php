<?php

namespace Isidea\HealthNotifier\Modules\Email\Adapter;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;
use Isidea\HealthNotifier\Contracts\Logging\Logger;
use Isidea\HealthNotifier\Contracts\Notifier;
use Isidea\HealthNotifier\Modules\Email\Mail\AppHealthNotification;

/**
 * @inheritdoc
 */
class EmailNotifier implements Notifier
{
    public function __construct(
        private AppHealthNotification $notification,
        private EmailNotificationSettingsRepository $settings,
        private Logger $logger
    ) {}

    /**
     * @inheritdoc
     */
    public function notify() : bool
    {
        // Проверяем, включены ли email уведомления в конфигурации
        if (!$this->settings->isEmailNotificationsEnabled()) return false;

        // Получаем список email получателей из конфигурации
        $recipients = $this->settings->getRecipients();

        $successMails = 0;

        foreach ($recipients as $email) {

            try {
                // Проверяем, является ли email валидным
                $validator = Validator::make(['email' => $email], [
                    'email' => 'required|email'
                ]);
    
                if ($validator->fails()) {
                    throw new \Exception("Невалидный email {$email}");
                }
    
                $this->logger->info('Отправка уведомления на email ' . $email);
                
                Mail::mailer($this->settings->getMailer())->to($email)->send($this->notification);
    
                $successMails += 1;
    
            } catch (\Exception $ex) {
    
                $this->logger->info("Ошибка при отправке уведомления на email {$email}: {$ex->getMessage()}");
            }
        }

        return $successMails > 0;
    }
}