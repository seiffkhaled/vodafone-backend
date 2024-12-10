<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatabaseNotificationRequest;
use App\Http\Requests\NotificationRequest;
use App\Services\NotificationDatabaseService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends Controller
{
    /**
     * Sends a notification to multiple recipients based on the provided request data.
     *
     * @param Request $request The incoming request containing 'emails', 'message', 'subject', and 'view'.
     * @throws \Exception If an error occurs during the notification sending process.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the result of the notification sending process.
     */
    public function handleNotificationRequest(NotificationRequest $request)
    {
        app()->setLocale($request->lang ?? 'en');
        $notificationService = new NotificationService();
        $notificationObject = $notificationService->prepareNotification($request);
        try {
            $notificationService->dispatchNotification($notificationObject);
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Notification sent successfully',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all notifications for a user.
     *
     * @param DatabaseNotificationRequest $request The incoming request containing 'user_id', 'is_read', 'offset', and 'limit'.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the notifications.
     */
    public function getAllNotifications(DatabaseNotificationRequest $request)
    {
        $notificationDatabaseService = new NotificationDatabaseService($request);
        $inputs = $notificationDatabaseService->extractInputs($request);
        if ($inputs['isRead']) {
            return  $notificationDatabaseService->getNotifications($inputs['userId'], $inputs['offset'], $inputs['limit'],$inputs['isRead']);
        } else {
            return  $notificationDatabaseService->getNotifications($inputs['userId'], $inputs['offset'], $inputs['limit'],$inputs['isRead']);
        }
    }
}
