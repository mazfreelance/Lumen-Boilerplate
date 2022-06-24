<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class EmailVerificationDTO extends DataTransferObject
{
    public $token;

    public static function fromRequest(Request $request)
    {
        return new self([
            'token' => $request->token
        ]);
    }
}
