<?php

namespace App\Ship\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StrongPassword implements Rule
{
    private $message = 'message.invalid_current_password';

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, Auth::user()->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
