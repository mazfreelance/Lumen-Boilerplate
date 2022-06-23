<?php

namespace App\Containers\v1\Notification\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class NotificationStoreDTO extends DataTransferObject
{
    public $notification_ids;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'notification_ids' => $request->notification_ids
        ]);
    }
}
