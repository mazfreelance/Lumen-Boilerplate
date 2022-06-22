<?php

namespace App\Containers\v1\User\Enums;

use App\Ship\Abstracts\Enums\Enum;

final class UserOnlineStatus extends Enum
{
    const Offline = 0;
    const Online = 1;
}
