<?php

namespace App\Containers\v1\Notification\ModelFilters;

use EloquentFilter\ModelFilter;

class NotificationFilter extends ModelFilter
{
    public function notifiable(int $notifiableId)
    {
        return $this->where('notifiable_id', $notifiableId);
    }

    public function notifiableType(string $notifiableType)
    {
        return $this->where('notifiable_type', $notifiableType);
    }

    public function message(string $message)
    {
        $jsonStr = addslashes(str_replace('"', '', json_encode($message)));
        $str = preg_match('/^"\\\\/', json_encode($message)) ? substr($jsonStr, 2) : $jsonStr;

        return $this->whereLike('data', $str);
    }
}
