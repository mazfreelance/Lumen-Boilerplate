<?php

namespace App\Ship\Providers;

use App\Ship\Support\{
    Executor,
    Helper,
    Logger,
    Responder
};
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use Laravel\Passport\Client;
use Ramsey\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('executor', function () {
            return new Executor;
        });

        $this->app->singleton('helper', function () {
            return new Helper;
        });

        $this->app->singleton('responder', function () {
            return new Responder;
        });

        $this->app->singleton('logger', function () {
            return new Logger;
        });
    }

    public function boot()
    {
        date_default_timezone_set(config('app.timezone'));

        $this->app->make(\Illuminate\Cache\RateLimiter::class)->for('global', function () {
            $limit = 250;
            $agent = new Agent();
            $whitelistIps = explode(',', config('app.whitelist.ip'));
            $ip = request()->header('x-real-ip', request()->ip());

            if (!in_array($ip, $whitelistIps) && $agent->isRobot()) {
                $limit = config('app.throttle_limit');
            }

            return \Illuminate\Cache\RateLimiting\Limit::perMinute($limit)->by($ip);
        });

        $this->app->make('queue');


        $this->createClient();
    }

    private function createClient()
    {
        $checkClientUuid = config('passport.client_uuids');

        $incrementing = true;
        if($checkClientUuid) {
            Client::creating(function (Client $client) {
                $client->incrementing = false;
                $client->id = Uuid::uuid4()->toString();
            });
            $incrementing = false;
        }

        Client::retrieved(function (Client $client) use ($incrementing) {
            $client->incrementing = $incrementing;
        });
    }
}
