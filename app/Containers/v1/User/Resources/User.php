<?php

namespace App\Containers\v1\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $permissions = $this->getDirectPermissions()->isNotEmpty() ? $this->getDirectPermissions() : $this->getPermissionsViaRoles();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'verification_token' => $this->verification_token,
            'status' => $this->status->value,
            'status_description' => $this->status->description,
            'verify_status' => $this->verify_status->value,
            'verify_status_description' => $this->verify_status->description,
            'online_status' => $this->online_status->value,
            'online_status_description' => $this->online_status->description,
            'permissions' => $permissions->map(function ($permission) {
                return collect($permission)->except('created_at', 'updated_at')->toArray();
            }),
            'role' => $this->roles->pluck('name'),
            'last_login_ip' => $this->last_login_ip,
            'last_login_at' => $this->last_login_at,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
