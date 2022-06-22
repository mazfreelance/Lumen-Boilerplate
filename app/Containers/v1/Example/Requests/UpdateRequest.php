<?php

namespace App\Containers\v1\Example\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'example_1' => 'required|string|bail',
            'example_2' => 'required|int|bail',
        ];
    }
}
