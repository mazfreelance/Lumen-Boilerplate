<?php

namespace App\Containers\v1\Authentication\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * @bodyParam email string required User email. Example: john.doe@example.com
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:filter|max:125|bail'
        ];
    }
}
