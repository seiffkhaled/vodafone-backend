<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use App\Models\NotificationObject;
use App\Http\Resources\NotificationResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\DatabaseNotificationRequest;

class NotificationDatabaseService
{
    protected $request;

    public function __construct(DatabaseNotificationRequest $request)
    {
        $this->request = $request;
    }

    public function extractInputs(DatabaseNotificationRequest $request): array
    {
        return [
            'userId' => $request->input('user_id'),
            'isRead' => $request->input('is_read'),
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', 3),
        ];
    }
    /**
     * Create a new notification instance for a user.
     *
     * @param User $recipient
     * @param NotificationObject $notificationObject
     * @return void
     */
    public static function createDatabaseNotification($recipientEmail, $notificationObject): void
    {
        $recipient = User::where('email', $recipientEmail)->first();
        Notification::create([
            'notifiable_id' => $recipient->id,
            'notifiable_type' => User::class,
            'type' => 'database',
            'data' => json_encode([
                'email' => $recipient->email,
                'name' => $recipient->username,
                'message' => $notificationObject->message
            ]),
        ]);
    }
    // /**
    //  * Get readed notifications for a user with pagination.
    //  *
    //  * @param int $userId The ID of the user.
    //  * @param int $offset The offset for pagination.
    //  * @param int $limit The limit for the number of notifications to retrieve.
    //  * @return \Illuminate\Database\Eloquent\Collection The collection of readed notifications.
    //  */
    // public function readedNotifications($userId, $offset, $limit): JsonResponse
    // {
    //     $user = User::findOrFail($userId);
    //     $notifications = Notification::where('notifiable_id', $user->id)
    //         ->whereNotNull('read_at')
    //         ->offset($offset)
    //         ->limit($limit)
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     if (count($notifications) > 0) {
    //         return response()->json(['data' => NotificationResource::collection($notifications)], Response::HTTP_OK);
    //     } else {
    //         return response()->json(['data' => []], Response::HTTP_OK);
    //     }
    // }

    // /**
    //  * Get unreaded notifications for a user with pagination.
    //  *
    //  * @param int $userId The ID of the user.
    //  * @param int $offset The offset for pagination.
    //  * @param int $limit The limit for the number of notifications to retrieve.
    //  * @return \Illuminate\Database\Eloquent\Collection The collection of unreaded notifications.
    //  */
    // public function unreadedNotifications($userId, $offset, $limit): JsonResponse
    // {
    //     $user = User::findOrFail($userId);
    //     $notifications = Notification::where('notifiable_id', $user->id)
    //         ->whereNull('read_at')
    //         ->offset($offset)
    //         ->limit($limit)
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     foreach ($notifications as $notification) {
    //         $notification->read_at = now();
    //         $notification->save();
    //     }
    //     if ($notifications->count() > 0) {
    //         return response()->json(['data' =>NotificationResource::collection($notifications)], Response::HTTP_OK);
    //     } else {
    //         return response()->json(['data' => []], Response::HTTP_OK);
    //     }
    // }

        /**
         * Get notifications for a user with pagination and optional read status filter.
         *
         * @param int $userId The ID of the user.
         * @param int $offset The offset for pagination.
         * @param int $limit The limit for the number of notifications to retrieve.
         * @param bool|null $isRead Optional parameter to filter by read status (true for read, false for unread, null for all).
         * @return JsonResponse The JSON response with the collection of notifications.
         */
        public function getNotifications($userId, $offset, $limit, ?bool $isRead = null): JsonResponse
        {
            $user = User::findOrFail($userId);
            $query = Notification::where('notifiable_id', $user->id)
                ->offset($offset)
                ->limit($limit)
                ->orderBy('created_at', 'desc');

            if ($isRead === true) {
                $query->whereNotNull('read_at');
            } elseif ($isRead === false) {
                $query->whereNull('read_at');
            }

            $notifications = $query->get();

            // Mark unread notifications as read if $isRead is false
            if ($isRead === false) {
                foreach ($notifications as $notification) {
                    $notification->read_at = now();
                    $notification->save();
                }
            }

            return response()->json(['data' => NotificationResource::collection($notifications)], Response::HTTP_OK);
        }

}
