<?php

namespace App\Containers\v1\Authentication\DTO;

use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ForgotPasswordDTO extends Data
{
    public function __construct(
        public string $email
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'email' => 'required|email:filter|max:125|bail'
        ];
    }
}
