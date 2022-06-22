<?php

namespace App\Ship\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void setApiVersion(string $version)
 * @method static string getApiVersion()
 * @method static mixed run(string $class, ...$args)
 *
 * @see \App\Ship\Support\Executor
 */
class Executor extends Facade
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
        return 'executor';
    }
}
