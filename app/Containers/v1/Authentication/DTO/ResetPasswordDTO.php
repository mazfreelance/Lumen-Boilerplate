<?php

namespace App\Containers\v1\Authentication\DTO;

use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ResetPasswordDTO extends Data
{
    public function __construct(
        public string $token,
        public string $password
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'token' => 'required|string|exists:password_resets,token|bail',
            'password' => 'required|alpha_num|confirmed|min:8|max:12|bail'
        ];
    }
}
