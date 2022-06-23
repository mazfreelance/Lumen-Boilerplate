<?php

namespace App\Containers\v1\Notification\Models;

use EloquentFilter\Filterable;
use App\Ship\Abstracts\Eloquent\Model;
use App\Containers\v1\Notification\ModelFilters\NotificationFilter;

class Notification extends Model
{
    use Filterable;

    protected $casts = [
        'id' => 'string',
        'data' => 'json'
    ];

    protected $fillable = ['type', 'notifiable_type', 'notifiable_id', 'data', 'read_at'];

    public function modelFilter()
    {
        return $this->provideFilter(NotificationFilter::class);
    }
}
