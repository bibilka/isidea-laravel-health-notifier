<?php

namespace Isidea\HealthNotifier\Modules\Email\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Isidea\HealthNotifier\Contracts\Email\EmailNotificationSettingsRepository;

/**
 * Mailable объект для отправки уведомления о состоянии приложения.
 */
class AppHealthNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private EmailNotificationSettingsRepository $settings
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->settings->getEmailFrom()),
            subject: $this->settings->getSubject()
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: $this->settings->getMarkdownTemplate()
        );
    }
}
