<?php

namespace App\Containers\v1\User\Enums;

use App\Ship\Abstracts\Enums\Enum;

/**
 * @method static static Inactive()
 * @method static static Active()
 */
final class UserStatus extends Enum
{
    const Inactive = 0;
    const Active = 1;
}
