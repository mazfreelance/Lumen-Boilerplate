<?php

namespace App\Containers\v1\User\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class UserStoreDTO extends DataTransferObject
{
    public $name;

    public $email;

    public $password;

    public $role;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);
    }
}
