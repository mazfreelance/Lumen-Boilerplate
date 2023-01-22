<?php

namespace App\Containers\v1\Authentication\DTO;

use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class EmailVerificationDTO extends Data
{
    public function __construct(
        public string $token
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'token' => 'required|string|max:255|exists:users,verification_token|bail'
        ];
    }
}
