<?php

namespace App\Containers\v1\Notification\Requests;

use App\Ship\Abstracts\Requests\FormRequest;

class MultiDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'notification_ids' => ['nullable', 'array', 'bail'],
            'notification_ids.*' => ['string', 'max:36', 'bail']
        ];
    }
}
