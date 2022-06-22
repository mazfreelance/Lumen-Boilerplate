<?php

namespace App\Ship\Support;

use App\Ship\Jobs\StoreServiceLog;
use App\Ship\Models\RequestLog;
use Illuminate\Http\Request;

/**
 * Logger
 *
 * @method void serviceLog(?int $userId = null, string $serviceType, string $path, ?array $headers = [], ?array $payload = [], int $statusCode, ?array $response = [])
 * @method void requestLog(string $requestId, Request $request, $excludeParameters)
 */
class Logger
{
    /**
     * Service Log
     *
     * @param integer|null $userId
     * @param string $serviceType
     * @param string $path
     * @param array|null $headers
     * @param array|null $payload
     * @param integer $statusCode
     * @param array|null $response
     * @return void
     */
    public function serviceLog(?int $userId = null, string $serviceType, string $path, ?array $headers = [], ?array $payload = [], int $statusCode, ?array $response = []): void
    {
        dispatch(new StoreServiceLog($userId, $serviceType, $path, $headers, $payload, $statusCode, $response));
    }

    /**
     * Request Log
     *
     * @param string $requestId
     * @param Request $request
     * @param mixed $excludeParameters
     * @return void
     */
    public function requestLog(string $requestId, Request $request, $excludeParameters): void
    {
        RequestLog::create([
            'request_id' => $requestId,
            'user_id' => $request->user()->id ?? null,
            'path' => $request->path(),
            'header' => collect($request->header())->except('cookie', 'authorization', 'user-agent'),
            'payload' => [
                'method' => $request->method(),
                'query' => $request->query(),
                'body' => collect($request->post())->except($excludeParameters)
            ],
            'ip_address' => $request->header('x-real-ip', request()->ip()),
            'user_agent' => $request->userAgent() ?? "Unknown user agent"
        ]);
    }
}
