<?php

namespace App\Containers\v1\Notification\DTO;

use Spatie\LaravelData\Data;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class NotificationStoreDTO extends Data
{
    public function __construct(
        public array $notification_ids
    ) {}

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'notification_ids' => ['required', 'array', 'bail'],
            'notification_ids.*' => ['integer', 'max:36', 'bail']
        ];
    }
}
