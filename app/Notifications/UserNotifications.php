<?php

namespace App\Notifications;

use App\Mail\MailNotification;
use App\Models\NotificationObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserNotifications extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $timeout = 5;
    public $throwable = true;
    public $maxExceptions = 2;
    public $notificationObject;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(NotificationObject $notificationObject, $user)
    {
        $this->user = $user;
        $this->notificationObject = $notificationObject;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($this->notificationObject->type == ['mail']) {
            return ['mail'];
        }elseif ($this->notificationObject->type == ['mail','database']) {
            return ['mail', 'database'];
        }
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $mailNotification = new MailNotification($this->notificationObject);
        return $mailNotification->to($notifiable->email)->cc($notifiable->email)->bcc($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'email' => $this->user->email,
            'name' => $this->user->name,
            'message' => $this->notificationObject->message[1]
        ];
    }
}
