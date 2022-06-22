<?php

namespace App\Ship\Providers;

use App\Containers\v1\Example\Events\{
    ExampleEvent
};
use App\Containers\v1\Example\Listeners\{
    ExampleListener
};
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ExampleEvent::class => [
            ExampleListener::class,
        ],
    ];
}
