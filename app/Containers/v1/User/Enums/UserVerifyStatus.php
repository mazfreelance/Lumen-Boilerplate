<?php

namespace App\Containers\v1\User\Enums;

use App\Ship\Abstracts\Enums\Enum;

/**
 * @method static static No()
 * @method static static Yes()
 */
final class UserVerifyStatus extends Enum
{
    const No = 0;
    const Yes = 1;
}
