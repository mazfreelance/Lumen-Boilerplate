<?php

namespace App\Containers\v1\Notification\Controllers;

use App\Containers\v1\Notification\DTO\NotificationStoreDTO;
use App\Containers\v1\Notification\Requests\{MultiDeleteRequest, MultiReadRequest};
use App\Containers\v1\Notification\Resources\Notification;
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Support\Facades\Executor;
use App\Ship\Support\Facades\Responder;
use Illuminate\Http\Request;

/**
 * @group Notification
 * @authenticated
 *
 * APIs for notification
 */
class Controller extends BaseController
{
    public function __construct()
    {
        Executor::setApiVersion('v1');
    }

    /**
     * Get All
     *
     * @queryParam message string The message of the notification. Example: Order Complete
     * @queryParam page integer The page of the request. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $action = Executor::run('Notification@GetAllAction', $request, $this->pageSize);

        return Responder::collection(Notification::collection($action));
    }

    /**
     * Get One
     *
     * @urlParam notificationId integer required The ID of the notification. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $notificationId)
    {
        $notification = Executor::run('Notification@GetOneAction', $notificationId);

        return Responder::success(new Notification($notification), __('message.success_retrieved'));
    }

    /**
     * Read
     *
     * @urlParam notificationId integer required The ID of the notification. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(string $notificationId)
    {
        Executor::run('Notification@ReadAction', $notificationId);

        return Responder::success([], __('message.success_update'));
    }

    /**
     * Multi Read
     *
     * @bodyParam notification_ids string[] required The IDs of the notification.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiRead(Request $request)
    {
        $notificationStoreDTO = NotificationStoreDTO::from($request);
        Executor::run('Notification@MultiReadAction', $notificationStoreDTO);

        return Responder::success([], __('message.success_update'));
    }

    /**
     * Multi Delete
     *
     * @bodyParam notification_ids string[] required The IDs of the notification.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiDelete(Request $request)
    {
        $notificationStoreDTO = NotificationStoreDTO::from($request);
        Executor::run('Notification@MultiDeleteAction', $notificationStoreDTO);

        return Responder::success([], __('message.success_delete'));
    }
}
