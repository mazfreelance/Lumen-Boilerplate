<?php

namespace App\Containers\v1\Example\Models;

use App\Containers\v1\Example\Enums\Example as EnumsExample;
use App\Containers\v1\Example\ModelFilters\ExampleFilter;
use App\Ship\Abstracts\Eloquent\Model;
use EloquentFilter\Filterable;

class Example extends Model
{
    use Filterable;

    protected $casts = [
        'example' => EnumsExample::class
    ];

    public function modelFilter()
    {
        return $this->provideFilter(ExampleFilter::class);
    }
}
