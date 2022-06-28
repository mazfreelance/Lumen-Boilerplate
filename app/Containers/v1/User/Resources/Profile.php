<?php

namespace App\Containers\v1\User\Resources;

use App\Ship\Support\Facades\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => Helper::maskEmail($this->email),
            'verify_status' => $this->verify_status->value,
            'verify_status_description' => $this->verify_status->description,
            'status' => $this->status->value,
            'status_description' => $this->status->description,
            'last_login_at' => $this->last_login_at,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
