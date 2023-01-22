<?php

namespace App\Containers\v1\Authentication\DTO;

use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ResendEmailVerificationDTO extends Data
{
    public function __construct(
        public ?string $email
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        $userId = Auth::id();
        return [
            "email" => ["nullable", "email:filter", "max:125", "unique:users,email,{$userId}", "bail"],
        ];
    }
}
