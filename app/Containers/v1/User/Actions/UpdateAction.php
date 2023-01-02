<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\DTO\UserUpdateDTO;
use App\Containers\v1\User\Enums\UserStatus;
use App\Containers\v1\User\Models\User;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\{DB, Hash};
use Spatie\Permission\Models\Role;

class UpdateAction
{
    public function execute(UserUpdateDTO $userUpdateDTO, int $id)
    {
        Helper::hasAnyPermission('user.edit');

        $user = User::findOrFail($id);

        $user->email = $userUpdateDTO->email;

        if($userUpdateDTO->name) $user->name = $userUpdateDTO->name;
        if($userUpdateDTO->password) $user->password = Hash::make($userUpdateDTO->password);
        if($userUpdateDTO->role)  $this->updateRoleAndPermissions($user, $userUpdateDTO->role);

        if($user->isDirty()) $user->save();
    }

    private function updateRoleAndPermissions(User $user, string $role): void
    {
        $permissions = Role::findByName($role)->permissions()->get();
        $user->assignRole($role);
        $user->syncPermissions($permissions);
    }
}
