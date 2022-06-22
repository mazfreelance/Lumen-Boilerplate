<?php

namespace App\Ship\ModelFilters;

use App\Ship\Support\FilterTraits\CreatedAtRangeFilterable;
use EloquentFilter\ModelFilter;

class ServiceLogFilter extends ModelFilter
{
    use CreatedAtRangeFilterable;

    public function user(int $userId)
    {
        return $this->where('user_id', $userId);
    }

    public function statusCode(string $statusCode)
    {
        return $this->where('status_code', $statusCode);
    }

    public function serviceType(string $serviceType)
    {
        return $this->whereLike('service_type', $serviceType);
    }

    public function path(string $path)
    {
        return $this->whereLike('path', $path);
    }
}
