<?php

namespace App\Containers\v1\User\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ChangePasswordDTO extends DataTransferObject
{
    public $current_password;

    public $new_password;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
        ]);
    }

}
