<?php

namespace App\Containers\v1\User\DTO;

use Spatie\LaravelData\Data;
use App\Ship\Rules\{CurrentPassword, StrongPassword};

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ChangePasswordDTO extends Data
{
    public function __construct(
        public string $current_password,
        public string $new_password
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'current_password' => ['required', 'string', new CurrentPassword, 'bail'],
            'new_password' => ['required', 'string', 'confirmed', 'min:8', new StrongPassword, 'bail']
        ];
    }
}
