<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class LoginDTO extends Data
{
    public function __construct(
        public string $email,
        public string $password,
        public ?bool $force = false
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
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
