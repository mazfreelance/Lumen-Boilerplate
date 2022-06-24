<?php

namespace App\Containers\v1\Authentication\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @bodyParam name string required User full name. Example: John Doe
     * @bodyParam email string required User email. Example: john.doe@example.com
     * @bodyParam password string required User login password. Example: 123456
     * @bodyParam password_confirmation string required User login password confirmation. Example: 123456
     * @bodyParam agree_term boolean required User agree terms and condition Example: 1
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:125|bail',
            'email' => 'required|email|unique:users|max:100|bail',
            'password' => 'required|string|confirmed|min:6|bail',
            'agree_term' => 'required|accepted|bail',
        ];
    }
}
