<?php

namespace App\Containers\v1\Authentication\Controllers;

use App\Containers\v1\Authentication\DTO\{EmailVerificationDTO, ForgotPasswordDTO, LoginDTO, RefreshTokenDTO, RegisterDTO, ResendEmailVerificationDTO, ResetPasswordDTO};
use App\Containers\v1\Authentication\Requests\{EmailVerificationRequest, ForgotPasswordRequest, LoginRequest, RegisterRequest, ResendEmailVerificationRequest, ResetPasswordRequest};
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Support\Facades\{Executor, Responder};
use Illuminate\Http\Request;

/**
 * @group Authentication
 *
 * APIs for authentication
 */
class Controller extends BaseController
{
    public function __construct()
    {
        Executor::setApiVersion('v1');
    }

    /**
     * Login
     *
     * @bodyParam email string required User email. Example: john.doe@example.com
     * @bodyParam password string required User login password. Example: 123456
     * @bodyParam force string required Whether to force login and revoke active session. Example: 0
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $loginDTO = LoginDTO::fromRequest($request);
        $tokenData = Executor::run('Authentication@LoginAction', $loginDTO);

        return Responder::success($tokenData, __('message.success_login'));
    }

    /**
     * Register
     *
     * @bodyParam name string required User full name. Example: John Doe
     * @bodyParam email string required User email. Example: john.doe@example.com
     * @bodyParam password string required User login password. Example: 123456
     * @bodyParam password_confirmation string required User login password confirmation. Example: 123456
     * @bodyParam agree_term boolean required User agree terms and condition Example: 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $registerDTO = RegisterDTO::fromRequest($request);
        Executor::run('Authentication@RegisterAction', $registerDTO);

        return Responder::success([], __('message.success_register'));
    }

    /**
     * Verify Email
     *
     * @bodyParam token string required The verification token send to user email. Example: ml9B7HmpE5elrpTiNe1HuD9d0jHlMFuPReMX0zFHoYI44Y5f2GrSkcCTFEqAdq2d
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function emailVerification(EmailVerificationRequest $request)
    {
        $emailVerificationDTO = EmailVerificationDTO::fromRequest($request);
        Executor::run('Authentication@EmailVerificationAction', $emailVerificationDTO);

        return Responder::success([], __('message.success_verify'));
    }

    /**
     * Forgot Password
     *
     * @bodyParam email email required The email for password reset. Example: john.doe@example.com
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $forgotPasswordDTO = ForgotPasswordDTO::fromRequest($request);
        Executor::run('Authentication@ForgotPasswordAction', $forgotPasswordDTO);

        return Responder::success([], __('message.success_sent'));
    }

    /**
     * Reset Password (Email)
     *
     * @bodyParam token string required The token for password reset. Example: k2UDGxhq3HCkwKcy5zcrUaJLBf2SFzmWImn1bnvA0bYCEDrrB9SAuRRBwvEo06RD
     * @bodyParam password string required The new password for the the password reset account. Example: abc123
     * @bodyParam password_confirmation string required The password confirmation for the password reset account. Example: abc123
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function resetPassword(ResetPasswordRequest $request)
    {
        $resetPasswordByEmailDTO = ResetPasswordDTO::fromRequest($request);
        Executor::run('Authentication@ResetPasswordAction', $resetPasswordByEmailDTO);

        return Responder::success([], __('message.success_update'));
    }

    /**
     * Refresh Token
     *
     * @bodyParam refresh_token string required The refresh token for the user account. Example: def5020061d3381f03599978184b4ae63f99e558990f9ce4bc28f5a257271c0e63e78a8
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $refreshTokenDTO = RefreshTokenDTO::fromRequest($request);
        $tokenData = Executor::run('Authentication@RefreshTokenAction', $refreshTokenDTO);

        return Responder::success($tokenData, __('message.success_refresh'));
    }

    /**
     * Logout
     *
     * @authenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Executor::run('Authentication@LogoutAction');

        return Responder::success([], __('message.success_logout'));
    }

    /**
     * Resend Email Verification
     *
     * @authenticated
     * @bodyParam email email The email to resend verification. Example: john.doe@example.com
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendEmailVerification(ResendEmailVerificationRequest $request)
    {
        $resendEmailVerificationDTO = ResendEmailVerificationDTO::fromRequest($request);
        $email = Executor::run('Authentication@ResendEmailVerificationAction', $resendEmailVerificationDTO);

        return Responder::success([], __('message.success_verify_sent', ['email' => $email]));
    }
}
