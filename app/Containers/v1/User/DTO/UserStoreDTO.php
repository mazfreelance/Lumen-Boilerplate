<?php

namespace App\Containers\v1\User\DTO;

use Spatie\LaravelData\Data;

class UserStoreDTO extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $role
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'name' => "required|alpha_dash|max:125|unique:users|bail",
            'email' => 'required|email|max:125|unique:users|bail',
            'password' => 'required|string|min:8|confirmed|bail',
            'role' => 'required|exists:roles,name|string|bail'
        ];
    }
}
