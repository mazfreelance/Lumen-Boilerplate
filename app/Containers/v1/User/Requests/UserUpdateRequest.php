<?php

namespace App\Containers\v1\User\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => "nullable|string|bail",
            'email' => "required|email|max:125|unique:users,email,{$this->userId}|bail",
            'password' => 'nullable|string|min:8|bail',
            'role' => 'required|exists:roles,name|string|bail'
        ];
    }
}
