<?php

namespace App\Ship\Middleware;

use App\Ship\Models\RequestLog;
use App\Ship\Support\Facades\Logger as FacadesLogger;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Logger
{
    protected $excludeParameters = ['password', 'password_confirmation', 'current_password', 'new_password', 'new_password_confirmation'];

    protected $excludeUrls = [
        '/',
        'oauth/token__POST',
        'v1/enum/*',
        'v1/user/me',
        'v1/examples',
        'v1/examples/*',
    ];

    private $strictMethodCheck = false;

    private $wildcardCheck = false;

    public function handle(Request $request, Closure $next)
    {
        if (config('app.log.request') == false) {
            goto skipper;
        }

        foreach ($this->excludeUrls as $excludeUrl) {
            $url = $excludeUrl;
            $requestUrl = $request->path();

            if ($this->isUrlInWildcard($excludeUrl, "__")) {
                $this->strictMethodCheck = true;
                [$url, $method] = explode("__", $excludeUrl);
            } else {
                $this->strictMethodCheck = false;
            }

            if ($this->isUrlInWildcard($excludeUrl, "/*")) {
                $this->wildcardCheck = true;
                $url = str_replace("/*", "", $url);
            } else {
                $this->wildcardCheck = false;
            }

            if ($this->strictMethodCheck && $this->wildcardCheck) {
                if ($this->isUrlInWildcard($requestUrl, $url) && $request->method() == $method) {
                    return $next($request);
                }
            } else if (!$this->strictMethodCheck && $this->wildcardCheck) {
                if ($this->isUrlInWildcard($requestUrl, $url)) {
                    return $next($request);
                }
            } else if ($this->strictMethodCheck && !$this->wildcardCheck) {
                if ($requestUrl == $url && $request->method() == $method) {
                    return $next($request);
                }
            } else {
                if ($requestUrl == $url) {
                    return $next($request);
                }
            }
        }

        $requestId = $this->createRequestLog($request);

        $request->merge(['request_id' => $requestId]);

        skipper:
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        if ($response instanceof JsonResponse && $request->has('request_id') && $response->getStatusCode() !== 500) {
            $this->updateRequestLog($request->request_id, $response);
        }
    }

    private function createRequestLog(Request $request): string
    {
        $requestId = Str::uuid()->toString();

        FacadesLogger::requestLog($requestId, $request, $this->excludeParameters);

        return $requestId;
    }

    private function updateRequestLog(string $requestId, JsonResponse $response): void
    {
        RequestLog::where('request_id', $requestId)->update(['response' => $response->getData(true) ?? []]);
    }

    private function isUrlInWildcard(string $requestUrl, string $url): bool
    {
        return strpos($requestUrl, $url) !== false;
    }
}
