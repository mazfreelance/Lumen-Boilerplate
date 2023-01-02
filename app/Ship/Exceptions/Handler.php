<?php

namespace App\Ship\Exceptions;

use App\Ship\Models\RequestLog;
use App\Ship\Support\Facades\Responder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\{HttpException, MethodNotAllowedHttpException, ServiceUnavailableHttpException};
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        AuthenticationException::class,
        BadRequestException::class,
        ThrottleRequestsException::class,
        GeneralHttpException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if (!$request->expectsJson()) {
        //     return parent::render($request, $exception);
        // }

        if ($exception instanceof AuthenticationException) {
            return Responder::unauthorized();
        } else if ($exception instanceof AuthorizationException) {
            return Responder::forbiddenAction();
        } else if ($exception instanceof ModelNotFoundException) {
            return Responder::notFound();
        } else if ($exception instanceof ValidationException) {
            return Responder::inputError($exception->errors());
        } else if ($exception instanceof BadRequestException) {
            return Responder::error($exception->getMessage());
        } else if ($exception instanceof ThrottleRequestsException) {
            return Responder::tooManyAttempts();
        } else if ($exception instanceof ServiceUnavailableHttpException) {
            return Responder::serverBusy();
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return Responder::methodNotAllowed();
        } else if ($exception instanceof GeneralHttpException) {
            return Responder::error($exception->getMessage(), $exception->getStatusCode());
        }else {
            if ($request->has('request_id')) {
                RequestLog::where('request_id', $request->request_id)->update([
                    'response' => [
                        "code" => 500,
                        "message" => $exception->getMessage(),
                    ]
                ]);
            }

            return Responder::serverError($exception->getMessage());
        }
    }
}
