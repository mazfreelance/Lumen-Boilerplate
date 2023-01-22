<?php

namespace App\Containers\v1\Authentication\DTO;

use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class RefreshTokenDTO extends Data
{
    public function __construct(
        public string $refresh_token
    ) {}
}
