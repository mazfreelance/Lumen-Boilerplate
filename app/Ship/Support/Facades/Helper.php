<?php

namespace App\Ship\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generatePasswordResetToken()
 * @method static bool isLoggedInAndHasRole(...$roles)
 * @method static bool isGuestOrNotHasRole(...$roles)
 * @method static void hasAnyPermission(...$permissions)
 * @method static array idsStringToArray(string $ids)
 * @method static bool compare($targetValue, $compareValue, string $operator)
 *
 * @see \App\Ship\Support\Helper
 */
class Helper extends Facade
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
        return 'helper';
    }
}
