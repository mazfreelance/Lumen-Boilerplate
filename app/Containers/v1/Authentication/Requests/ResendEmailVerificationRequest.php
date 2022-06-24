<?php

namespace App\Containers\v1\Authentication\Requests;

use App\Ship\Abstracts\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResendEmailVerificationRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = Auth::id();
        return [
            "email" => ["nullable", "email:filter", "max:125", "unique:users,email,{$userId}", "bail"],
        ];
    }
}
