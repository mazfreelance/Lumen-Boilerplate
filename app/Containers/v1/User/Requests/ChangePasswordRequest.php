<?php

namespace App\Containers\v1\User\Requests;

use App\Ship\Abstracts\Requests\FormRequest;
use App\Ship\Rules\{CurrentPassword, StrongPassword};

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', new CurrentPassword, 'bail'],
            'new_password' => ['required', 'string', 'confirmed', 'min:8', new StrongPassword, 'bail']
        ];
    }
}
