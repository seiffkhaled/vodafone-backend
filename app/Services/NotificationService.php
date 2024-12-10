<?php

namespace App\Services;

use App\Mail\MailNotification;
use App\Models\NotificationObject;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class NotificationService
{
    public function prepareNotification($request): NotificationObject
    {
        return new NotificationObject(
            $request->input('type'),
            $request->input('emails'),
            $request->input('subject') ?? null,
            $request->input('message'),
            $request->input('attachments') ?? null,
            $request->input('view') ?? null,
        );
    }
    public function dispatchNotification($notificationObject)
    {
        foreach ($notificationObject->emails as $recipientEmail) {
            if (!$recipientEmail) {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'Recipient email not found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Create database notification if 'database' type exists
            if (in_array('database', $notificationObject->type)) {
                NotificationDatabaseService::createDatabaseNotification($recipientEmail, $notificationObject);
            }

            // Send mail if 'mail' type exists
            if (in_array('mail', $notificationObject->type)) {
                Mail::to($recipientEmail)->send(new MailNotification($notificationObject));
            }
        }
    }
}
