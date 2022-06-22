<?php

namespace App\Ship\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static void serviceLog(?int $userId = null, string $serviceType, string $path, ?array $headers = [], ?array $payload = [], int $statusCode, ?array $response = [])
 * @method static void requestLog(string $requestId, Request $request, $excludeParameters)
 *
 * @see \App\Ship\Support\Logger
 */
class Logger extends Facade
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
        return 'logger';
    }
}
