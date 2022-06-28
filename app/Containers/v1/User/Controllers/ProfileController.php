<?php

namespace App\Containers\v1\User\Controllers;

use App\Containers\v1\User\DTO\{ChangePasswordDTO};
use App\Containers\v1\User\Requests\{ChangePasswordRequest};
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Rules\Base64Image;
use App\Ship\Support\Facades\{Executor, Responder};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @group Profile
 * @authenticated
 *
 * APIs for user profile
 */
class ProfileController extends BaseController
{
    public function __construct()
    {
        Executor::setApiVersion('v1');
    }

    /**
     * Me
     *
     * Get currently login user information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = Executor::run('User@GetMeAction');

        return Responder::success($user, __('message.success_retrieve'));
    }

    /**
     * Change Password
     *
     * @bodyParam current_password string required The current password. Example: abc123
     * @bodyParam new_password string required The new password. Example: SarahMac
     * @bodyParam new_password_confirmation string required The new password confirmation. Example: SarahMac
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $changePasswordDTO = ChangePasswordDTO::fromRequest($request);
        Executor::run('User@ChangePasswordAction', $changePasswordDTO);

        return Responder::success([], __('message.success_update'));
    }
}
