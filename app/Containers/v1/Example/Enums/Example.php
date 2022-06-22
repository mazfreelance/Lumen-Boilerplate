<?php

namespace App\Containers\v1\Example\Enums;

use App\Ship\Abstracts\Enums\Enum;

/**
 * @method static static Active()
 * @method static static Inactive()
 */
final class Example extends Enum
{
    const Active = 0;
    const Inactive = 1;
}
