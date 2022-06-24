<?php

namespace App\Ship\Providers;

use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        LumenPassport::routes($this->app);
        Passport::personalAccessTokensExpireIn(Carbon::now()->addMinutes(20));
        LumenPassport::tokensExpireIn(Carbon::now()->addMinutes(20));
        Passport::refreshTokensExpireIn(Carbon::now()->addHour());
        LumenPassport::allowMultipleTokens();
        Passport::hashClientSecrets();
    }
}
