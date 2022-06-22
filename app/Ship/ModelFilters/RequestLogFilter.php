<?php

namespace App\Ship\ModelFilters;

use App\Ship\Support\FilterTraits\CreatedAtRangeFilterable;
use EloquentFilter\ModelFilter;

class RequestLogFilter extends ModelFilter
{
    use CreatedAtRangeFilterable;

    public function userAgent(string $userAgent)
    {
        return $this->whereLike('user_agent', $userAgent);
    }

    public function user(int $userId)
    {
        return $this->where('user_id', $userId);
    }

    public function path(string $path)
    {
        return $this->whereLike('path', $path);
    }

    public function ipAddress(string $ipAddress)
    {
        return $this->where('ip_address', $ipAddress);
    }
}
