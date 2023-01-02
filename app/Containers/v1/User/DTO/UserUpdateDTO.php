<?php

namespace App\Containers\v1\User\DTO;

use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class UserUpdateDTO extends Data
{
    public function __construct(
        public ?string $name,
        public string $email,
        public ?string $password,
        public ?string $role
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        $userId = request()->id;

        return [
            'name' => "nullable|string|bail",
            'email' => "required|email|max:125|unique:users,email,{$userId}|bail",
            'password' => 'nullable|string|min:8|confirmed|bail',
            'role' => 'nullable|exists:roles,name|string|bail'
        ];
    }
}
