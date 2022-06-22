<?php

namespace App\Ship\Abstracts\Enums;

use BenSampo\Enum\Enum as BaseEnum;
use Illuminate\Support\Collection;

abstract class Enum extends BaseEnum
{
    public static function getCollection()
    {
        return Collection::make(static::asArray())->values()->map(function($value) {
            return [
                "key" => static::getKey($value),
                "description" => static::getDescription($value),
                "value" => $value
            ];
        });
    }
}
