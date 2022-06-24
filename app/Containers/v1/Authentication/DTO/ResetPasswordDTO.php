<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ResetPasswordDTO extends DataTransferObject
{
    public $token;

    public $password;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'token' => $request->token,
            'password' => $request->password,
        ]);
    }

}
