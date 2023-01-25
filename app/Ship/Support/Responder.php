<?php

namespace App\Ship\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

/**
 * Responder
 *
 * @method JsonResponse success(array $data = [], ?string $message = null, int $code = JsonResponse::HTTP_OK)
 * @method JsonResponse notFound(?string $message = null)
 * @method JsonResponse inputError(array $errors)
 * @method JsonResponse serverError(string $message)
 * @method JsonResponse error(string $message, int $code = JsonResponse::HTTP_BAD_REQUEST, int $errorNo)
 * @method JsonResponse unauthorized()
 * @method JsonResponse forbiddenAccess()
 * @method JsonResponse forbiddenManage()
 * @method JsonResponse forbiddenAction()
 * @method JsonResponse forbiddenLogin()
 * @method JsonResponse tooManyAttempts()
 */
class Responder
{
    /**
     * Success
     *
     * @param object|array $data
     * @param string|null $message
     * @param integer $code
     * @return JsonResponse
     */
    public function success($data = [], ?string $message = null, int $code = JsonResponse::HTTP_OK): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Not Found
     *
     * @return JsonResponse
     */
    public function notFound(?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => JsonResponse::HTTP_NOT_FOUND,
            'message' => $message ?? __('message.no_record'),
        ], JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * Input Error
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function inputError(array $errors): JsonResponse
    {
        return response()->json([
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'message' => __('message.invalid_input'),
            'errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Server Error
     *
     * @param string $message
     * @return JsonResponse
     */
    public function serverError(string $message): JsonResponse
    {
        return response()->json([
            'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => App::environment('production') || empty($message) ? __('message.server_error') : $message,
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Server Busy
     *
     * @param string $message
     * @return JsonResponse
     */
    public function serverBusy(): JsonResponse
    {
        return response()->json([
            'code' => JsonResponse::HTTP_SERVICE_UNAVAILABLE,
            'message' => __('message.server_busy'),
        ], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Method Not Allowed
     *
     * @return JsonResponse
     */
    public function methodNotAllowed(): JsonResponse
    {
        return response()->json([
            'code' => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
            'message' => __('message.method_not_allowed'),
        ], JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * Error
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function error(string $message, int $code = JsonResponse::HTTP_BAD_REQUEST, int $errorNo = 0): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'error' => $errorNo,
            'message' => $message,
        ], $code);
    }

    /**
     * Unauthorized
     *
     * @return JsonResponse
     */
    public function unauthorized(): JsonResponse
    {
        return $this->error(__('message.unauthorized'), JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Forbidden Access
     *
     * @return JsonResponse
     */
    public function forbiddenAccess(): JsonResponse
    {
        return $this->error(__('message.no_permission_access'), JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Forbidden Manage
     *
     * @return JsonResponse
     */
    public function forbiddenManage(): JsonResponse
    {
        return $this->error(__('message.no_permission_manage'), JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Forbidden Action
     *
     * @return JsonResponse
     */
    public function forbiddenAction(): JsonResponse
    {
        return $this->error(__('message.no_permission_perform_action'), JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Forbidden Login
     *
     * @return JsonResponse
     */
    public function forbiddenLogin(): JsonResponse
    {
        return $this->error(__('message.no_permission_login'), JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Too Many Attempts
     *
     * @return JsonResponse
     */
    public function tooManyAttempts(): JsonResponse
    {
        return $this->error(__('message.too_many_attempts'), JsonResponse::HTTP_TOO_MANY_REQUESTS);
    }
}
