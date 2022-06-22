<?php

namespace App\Ship\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $acceptLanguage = $request->header('Accept-Language');

        if ($acceptLanguage) {
            App::setLocale($acceptLanguage);
        }

        return $next($request);
    }
}
