<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\Models\User;
use App\Ship\Support\Facades\Helper;

class GetOneAction
{
    public function execute(string $id)
    {
        Helper::hasAnyPermission('user.one');

        return User::with('roles', 'permissions')->findOrFail($id);
    }
}
