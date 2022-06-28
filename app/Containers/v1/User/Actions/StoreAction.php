<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\DTO\UserStoreDTO;
use App\Containers\v1\User\Enums\UserStatus;
use App\Containers\v1\User\Models\User;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\{DB, Hash};
use Spatie\Permission\Models\Role;

class StoreAction
{
    public function execute(UserStoreDTO $userStoreDTO)
    {
        Helper::hasAnyPermission('user.create');

        DB::transaction(function () use ($userStoreDTO) {
            $user = User::create([
                'name' => $userStoreDTO->name,
                'email' => $userStoreDTO->email,
                'password' => Hash::make($userStoreDTO->password),
                'status' => UserStatus::Active,
            ]);

            $this->updateRoleAndPermissions($user, $userStoreDTO->role);
        });
    }

    private function updateRoleAndPermissions(User $user, string $role): void
    {
        $permissions = Role::findByName($role)->permissions()->get();
        $user->assignRole($role);
        $user->syncPermissions($permissions);
    }
}
