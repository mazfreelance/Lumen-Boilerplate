<?php

namespace App\Ship\Enums;

use App\Ship\Abstracts\Enums\Enum;

/**
 * @method static static English()
 * @method static static Malay()
 */
final class SystemLocale extends Enum
{
    const English = 'en';
    const Malay = 'ms';
}
