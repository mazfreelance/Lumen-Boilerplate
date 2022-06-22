<?php

namespace App\Ship\Enums;

use App\Ship\Abstracts\Enums\Enum;

/**
 * @method static static Authentication()
 * @method static static Export()
 * @method static static Log()
 * @method static static Notification()
 */
final class QueueType extends Enum
{
    const Authentication = 'authentication';
    const Export = 'export';
    const Log = 'log';
    const Notification = 'notification';
}
