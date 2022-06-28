<?php

namespace App\Containers\v1\User\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => "required|alpha_dash|max:125|unique:users|bail",
            'email' => 'required|email|max:125|unique:users|bail',
            'password' => 'required|string|min:8|bail',
            'role' => 'required|exists:roles,name|string|bail'
        ];
    }
}
