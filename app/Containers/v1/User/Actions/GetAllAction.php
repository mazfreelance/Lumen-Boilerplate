<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\Models\User;
use App\Ship\Support\Facades\Helper;
use Illuminate\Http\Request;

class GetAllAction
{
    public function execute(Request $request, int $pageSize)
    {
        Helper::hasAnyPermission('user.list-all');

        return User::filter($request->toArray())
            ->with('roles', 'permissions')
            ->latest('id')
            ->paginate($pageSize);
    }
}
