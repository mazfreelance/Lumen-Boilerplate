<?php

namespace App\Ship\Models;

use App\Ship\Abstracts\Eloquent\Model;
use App\Ship\ModelFilters\RequestLogFilter;
use EloquentFilter\Filterable;

class RequestLog extends Model
{
    use Filterable;

    protected $casts = [
        'header' => 'json',
        'payload' => 'json',
        'response' => 'json'
    ];

    protected $fillable = ['request_id', 'user_id', 'path', 'header', 'payload', 'response', 'ip_address', 'user_agent'];

    public function modelFilter()
    {
        return $this->provideFilter(RequestLogFilter::class);
    }
}
