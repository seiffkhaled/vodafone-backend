<?php

namespace App\Models;

class NotificationObject
{
    public $type;
    public $emails;
    public $subject;
    public $message;
    public $attachments;
    public $view;
    public function __construct(array $type,array $emails, ?string $subject = null, array $message, ?array $attachments = [] ?? null , ?string $view = null)
    {
        $this->type = $type;
        $this->emails = $emails;
        $this->message = $message;
        $this->subject = $subject;
        $this->attachments = $attachments;
        $this->view = $view;
    }
}
