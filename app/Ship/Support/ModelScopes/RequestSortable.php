<?php

namespace App\Ship\Support\ModelScopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait RequestSortable
{
    public function scopeSortable(Builder $query, ?string $sort = null): Builder
    {
        if ($sort) {
            $sortOptions = explode("|", $sort);

            foreach ($sortOptions as $sortOption) {
                [$column, $order] = explode(",", $sortOption);
                $query = $query->when(in_array($column, ['sort_order', 'product_sort_order']), function (Builder $query) use ($column) {
                    return $query->orderBy(DB::raw("ISNULL({$column}), {$column}"), "asc");
                })->orderBy($column, $order);
            }

            return $query;
        }

        return $query->latest();
    }
}
