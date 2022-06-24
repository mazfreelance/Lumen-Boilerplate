<?php

namespace App\Containers\v1\Authentication\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    /**
     * @bodyParam email string required User email. Example: john.doe@example.com
     * @bodyParam token string required verification password token. Example: 123456
     * @bodyParam force string required Whether to force login and revoke active session. Example: 0
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string|max:255|exists:users,verification_token|bail'
        ];
    }
}
