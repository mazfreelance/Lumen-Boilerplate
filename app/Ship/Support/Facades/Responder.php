<?php

namespace App\Ship\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse success(array $data, string $message, int $code = 200)
 * @method static \Illuminate\Http\JsonResponse error(string $message, int $code = 400)
 * @method static \Illuminate\Http\JsonResponse inputError(array $errors)
 * @method static \Illuminate\Http\JsonResponse serverError(string $message)
 * @method static \Illuminate\Http\JsonResponse serverBusy()
 * @method static \Illuminate\Http\JsonResponse notFound()
 * @method static \Illuminate\Http\JsonResponse unauthorized()
 * @method static \Illuminate\Http\JsonResponse forbiddenAccess()
 * @method static \Illuminate\Http\JsonResponse forbiddenManage()
 * @method static \Illuminate\Http\JsonResponse forbiddenAction()
 * @method static \Illuminate\Http\JsonResponse forbiddenLogin()
 * @method static \Illuminate\Http\JsonResponse tooManyAttempts()
 * @method static \Illuminate\Http\JsonResponse collection(array $data = [])
 * @method static \Illuminate\Http\JsonResponse methodNotAllowed()
 *
 * @see \App\Ship\Support\Responder
 */
class Responder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'responder';
    }
}
