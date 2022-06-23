<?php

namespace App\Containers\v1\Notification\Resources;

use App\Ship\Enums\SystemLocale;
use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
{
    public function toArray($request)
    {
        $language = $request->header('Accept-Language', SystemLocale::English);

        return [
            'id' => $this->id,
            'data' => $this->data[$language] ?? $this->data,
            'addons' => $this->data['addons'] ?? [],
            'read_at' => $this->read_at,
            'created_at' => $this->created_at ? $this->created_at->toDatetimeString() : null
        ];
    }
}
