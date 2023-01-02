<?php

namespace App\Containers\v1\User\Controllers;

use App\Containers\v1\User\DTO\{ChangePasswordDTO};
use App\Containers\v1\User\Resources\Profile;
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Support\Facades\{Executor, Responder};
use Illuminate\Http\Request;

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

        return Responder::success(new Profile($user), __('message.success_retrieve'));
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
    public function changePassword(Request $request)
    {
        $changePasswordDTO = ChangePasswordDTO::from($request);
        Executor::run('User@ChangePasswordAction', $changePasswordDTO);

        return Responder::success([], __('message.success_update'));
    }
}
