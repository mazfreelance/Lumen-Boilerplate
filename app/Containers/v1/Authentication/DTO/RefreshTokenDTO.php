<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class RefreshTokenDTO extends DataTransferObject
{
    public $refresh_token;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'refresh_token' => $request->refresh_token,
        ]);
    }

}
