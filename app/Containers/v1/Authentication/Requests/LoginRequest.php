<?php

namespace App\Containers\v1\Authentication\Requests;

use App\Ship\Abstracts\Requests\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    /**
     * @bodyParam email string required User email. Example: john.doe@example.com
     * @bodyParam password string required User login password. Example: 123456
     * @bodyParam force string required Whether to force login and revoke active session. Example: 0
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|bail',
            'password' => 'required|string|bail',
            'force' => [
                Rule::requiredIf(!config('app.allow_login_multiple_token')),
                'boolean',
                'bail'
            ]
        ];
    }
}
