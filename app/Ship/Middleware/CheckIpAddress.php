<?php

namespace App\Ship\Middleware;

use App\Ship\Support\Facades\Responder;
use Closure;
use Illuminate\Http\Request;

class CheckIpAddress
{
    public function handle(Request $request, Closure $next)
    {
        if (config('app.whitelist.enabled')) {
            $whitelistIps = explode(',', config('app.whitelist.ip'));

            if (!in_array($request->ip(), $whitelistIps)) {
                return Responder::error(__('message.ip_not_whitelist'), 403);
            }
        }

        return $next($request);
    }
}
