<?php

namespace App\Containers\v1\Authentication\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * @bodyParam token string required The token for password reset. Example: k2UDGxhq3HCkwKcy5zcrUaJLBf2SFzmWImn1bnvA0bYCEDrrB9SAuRRBwvEo06RD
     * @bodyParam password string required The new password for the the password reset account. Example: abc123
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:password_resets,token|bail',
            'password' => 'required|alpha_num|confirmed|min:8|max:12|bail',
        ];
    }
}
