<?php

namespace Database\Seeders;

use App\Containers\v1\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsName = $this->getPermissions();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Schema::disableForeignKeyConstraints();

        // Delete permission that no longer exists
        Permission::whereNotIn('name', $permissionsName)->each(function ($permission) {
            $permission->roles->each(function ($role) use ($permission) {
                $role->revokePermissionTo($permission);
                $permission->delete();

                DB::table('role_has_permissions')->where('permission_id', $permission->id)->delete();
                DB::table('model_has_permissions')->where('permission_id', $permission->id)->delete();
            });
        });

        $rolesData = $this->getRolesData($permissionsName);

        $newPermissions = Collection::make();
        $permissionsName->each(function ($permissionName) use ($newPermissions) {
            $permission = $this->getOrCreatePermission($permissionName);

            if ($permission->wasRecentlyCreated) {
                $newPermissions->push($permissionName);
            }
        });

        $rolesData->each(function ($roleData) use ($newPermissions) {
            $permissions = array_intersect($newPermissions->toArray(), $roleData['permissions']);
            $role = $this->getOrCreateRole($roleData['name']);
            $role->givePermissionTo($permissions);

            if (!empty($permissions)) {
                User::role($role)->each(function (User $user) use ($permissions) {
                    if ($user->getDirectPermissions()->isNotEmpty()) {
                        $user->givePermissionTo($permissions);
                    }
                });
            }
        });
    }

    private function getPermissions(): Collection
    {
        return Collection::make([
            'user.list-all', 'user.one', 'user.create', 'user.edit', 'user.destroy', 'user.export',
        ]);
    }

    private function getRolesData(Collection $permissions): Collection
    {
        return Collection::make([
            [
                'name' => 'admin',
                'permissions' => $permissions->all()
            ],
            [
                'name' => 'developer',
                'permissions' => $permissions->all()
            ],
            [
                'name' => 'user',
                'permissions' => []
            ]
        ]);
    }

    private function getOrCreatePermission(string $name): Permission
    {
        return Permission::firstOrCreate([
            'name' => $name,
            'guard_name' => 'api'
        ]);
    }

    private function getOrCreateRole(string $name): Role
    {
        return Role::firstOrCreate(['name' => $name]);
    }
}
