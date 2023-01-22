<?php

namespace App\Containers\v1\Authentication\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\{MapInputName, MapOutputName};

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class RegisterDTO extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public bool $agree_term
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:125|bail',
            'email' => 'required|email|unique:users|max:100|bail',
            'password' => 'required|string|confirmed|min:6|bail',
            'agree_term' => 'required|accepted|bail'
        ];
    }
}
