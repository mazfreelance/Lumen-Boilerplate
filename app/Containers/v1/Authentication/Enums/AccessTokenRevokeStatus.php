<?php

namespace App\Containers\v1\Authentication\Enums;

use App\Ship\Abstracts\Enums\Enum;

/**
 * @method static static Revoked()
 * @method static static Available()
 */
final class AccessTokenRevokeStatus extends Enum
{
    const Revoked = 1;
    const Available = 0;
}
