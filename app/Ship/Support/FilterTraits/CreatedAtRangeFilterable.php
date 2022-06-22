<?php

namespace App\Ship\Support\FilterTraits;

use Illuminate\Support\Carbon;

trait CreatedAtRangeFilterable
{
    /**
     * @param string $dateRange Date range to filter. Example: 2020/10/10-2020/11/11
     */
    public function createdAtRange(string $dateRange)
    {
        [$startDate, $endDate] = explode('-', $dateRange);

        return $this->whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay()->toDateTimeString(),
            Carbon::parse($endDate)->endOfDay()->toDateTimeString()
        ]);
    }
}
