<?php

namespace App\Containers\v1\Enum\Controllers;

use App\Containers\v1\User\Enums\UserOnlineStatus;
use App\Containers\v1\User\Enums\UserStatus;
use App\Containers\v1\User\Enums\UserVerifyStatus;
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Enums\{QueueType, SystemLocale};
use App\Ship\Support\Facades\{Executor, Responder};

/**
 * @group Enum
 *
 * APIs for enum option
 */
class Controller extends BaseController
{
    public function __construct()
    {
        Executor::setApiVersion('v1');
    }

    /**
     * Queue Type
     *
     * Queue type enum request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function queueType()
    {
        return Responder::success(QueueType::getCollection(), __('message.success_retrieve'));
    }

    /**
     * System Locale
     *
     * System locale enum request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function systemLocale()
    {
        return Responder::success(SystemLocale::getCollection(), __('message.success_retrieve'));
    }

    /**
     * User Online Status
     *
     * User online status enum request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userOnlineStatus()
    {
        return Responder::success(UserOnlineStatus::getCollection(), __('message.success_retrieve'));
    }

    /**
     * User Status
     *
     * User status enum request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userStatus()
    {
        return Responder::success(UserStatus::getCollection(), __('message.success_retrieve'));
    }

    /**
     * User Verify Status
     *
     * User verify status enum request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userVerifyStatus()
    {
        return Responder::success(UserVerifyStatus::getCollection(), __('message.success_retrieve'));
    }
}
