<?php

namespace App\Mail;

use App\Models\NotificationObject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $notificationObject;

    /**
     * Create a new message instance.
     */
    public function __construct(NotificationObject $notificationObject)
    {
        $this->notificationObject = $notificationObject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: env('MAIL_FROM_ADDRESS'),
            subject: $this->notificationObject->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->notificationObject->view ?? null,
            with: [
                'subjects' => $this->notificationObject->subject,
                'header' => $this->notificationObject->message[0],
                'bodyLines' => $this->notificationObject->message[1],
                'footer' => $this->notificationObject->message[2],
            ]
        );
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->notificationObject->attachments ?? [];
    }
}
