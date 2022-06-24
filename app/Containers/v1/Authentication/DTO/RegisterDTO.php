<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class RegisterDTO extends DataTransferObject
{
    public $name;

    public $email;

    public $password;

    public $agree_term;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'agree_term' => $request->agree_term,
        ]);
    }

}
