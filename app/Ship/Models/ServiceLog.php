<?php

namespace App\Ship\Models;

use EloquentFilter\Filterable;
use App\Ship\Abstracts\Eloquent\Model;
use App\Containers\v1\User\Models\User;
use App\Ship\ModelFilters\ServiceLogFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceLog extends Model
{
    use Filterable;

    public $timestamps = false;

    protected $casts = [
        'header' => 'json',
        'payload' => 'json',
        'response' => 'json'
    ];

    protected $guarded = [];

    public function modelFilter()
    {
        return $this->provideFilter(ServiceLogFilter::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
