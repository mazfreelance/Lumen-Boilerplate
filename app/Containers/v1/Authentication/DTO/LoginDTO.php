<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class LoginDTO extends DataTransferObject
{
    public $email;

    public $password;

    public $force;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'email' => $request->email,
            'password' => $request->password,
            'force' => $request->force ?? false
        ]);
    }

}
