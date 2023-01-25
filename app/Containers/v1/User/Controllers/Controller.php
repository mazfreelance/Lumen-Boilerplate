<?php

namespace App\Containers\v1\User\Controllers;

use App\Containers\v1\User\DTO\{UserStoreDTO, UserUpdateDTO};
use App\Containers\v1\User\Requests\{UserStoreRequest, UserUpdateRequest};
use App\Containers\v1\User\Resources\{User, UserCollection};
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Support\Facades\{Executor, Responder};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @group User
 * @authenticated
 *
 * APIs for User management
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
     * @queryParam username string The username of the user. Example: wendy
     * @queryParam email string The email of the user. Example: qjohnston@example.org
     * @queryParam phone_no string The phone number of the user. Example: 66831716143
     * @queryParam referral_code string The referral code of the user. Example: sVRHgzIH
     * @queryParam referrer_code string The referral code of the user referrer. Example: sVRHgzIH
     * @queryParam status integer The status of the user. Example: 1
     * @queryParam block_status integer The block status of the user. Example: 1
     * @queryParam suspend_status integer The suspend status of the user. Example: 1
     * @queryParam is_dtac_status integer The is dtac status of the user. Example: 1
     * @queryParam lock_status integer The lock status of the user. Example: 1
     * @queryParam subscribe_status integer The subscribe status of the user. Example: 1
     * @queryParam email_status integer The email status of the user. Example: 1
     * @queryParam pay_type integer The pay type of the user. Example: 1
     * @queryParam created_at_range string The created at range of the user. Example: 2020/12/01 - 2020/12/31
     * @queryParam page integer The page of the request. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = Executor::run('User@GetAllAction', $request, $this->pageSize);

        return Responder::success(new UserCollection($users));
    }

    /**
     * Create
     *
     * @bodyParam username string required The username of user. Example: johndoe
     * @bodyParam email email required The email of user. Example: john.doe@example.com
     * @bodyParam password string required The password of the user. Example: abc123123123
     * @bodyParam role string required The role for the user account. Example: admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $userStoreDTO = UserStoreDTO::from($request);
        Executor::run('User@StoreAction', $userStoreDTO);

        return Responder::success([], __('message.success_create'));
    }

    /**
     * Get One
     *
     * @urlParam userId integer required The ID of the user. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $user = Executor::run('User@GetOneAction', $id);

        return Responder::success(new User($user), __('message.success_retrieved'));
    }

    /**
     * Update
     *
     * @urlParam userId integer required The ID of the user. Example: 1
     * @bodyParam username string required The username of user. Example: johndoe
     * @bodyParam email email required The email of user. Example: john.doe@example.com
     * @bodyParam password string required The password of the user. Example: abc123123123
     * @bodyParam role string required The role for the user account. Example: admin
     * @bodyParam suspend_status integer required The suspend status for the user account. Example: 1
     * @bodyParam suspend_from string required The suspend start date for the user account. Example: 2022-05-10
     * @bodyParam suspend_to string required The suspend end date for the user account. Example: 2022-05-24
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $userUpdateDTO = UserUpdateDTO::from($request);
        Executor::run('User@UpdateAction', $userUpdateDTO, $id);

        return Responder::success([], __('message.success_update'));
    }

    /**
     * Delete
     *
     * @urlParam userId integer required The ID of the user. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $user = Executor::run('User@DeleteAction', $id);

        return Responder::success(new User($user), __('message.success_delete'));
    }

    /**
     * Export
     *
     * @queryParam username string The username of the user. Example: wendy
     * @queryParam email string The email of the user. Example: qjohnston@example.org
     * @queryParam phone_no string The phone number of the user. Example: 66831716143
     * @queryParam status integer The status of the user. Example: 1
     * @queryParam block_status integer The block status of the user. Example: 1
     * @queryParam lock_status integer The lock status of the user. Example: 1
     * @queryParam subscribe_status integer The subscribe status of the user. Example: 1
     * @queryParam email_status integer The email status of the user. Example: 1
     * @queryParam pay_type integer The pay type of the user. Example: 1
     * @queryParam created_at_range string The created at range of the user. Example: 2020/12/01 - 2020/12/31
     * @queryParam page integer The page of the request. Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function export(Request $request)
    {
        Executor::run('User@ExportAction', $request);

        return Responder::success([], __('message.success_export'));
    }
}
