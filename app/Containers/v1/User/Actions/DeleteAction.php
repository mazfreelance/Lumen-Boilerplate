<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\Models\User;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DeleteAction
{
    public function execute(int $userId)
    {
        Helper::hasAnyPermission('user.destroy');

        if (Auth::id() != $userId) throw new BadRequestException(__('message.you_cant_delete_yourself'));

        $user = $this->getUser($userId);

        if ($user->hasRole('admin')) throw new BadRequestException(__('message.you_cant_delete_admin'));

        DB::transaction(function () use ($user) {
            $token = $user->token();
            $user->revokeAllToken($token);
            $user->delete();
        });
    }

    private function getUser(int $userId): User
    {
        return User::find($userId);
    }
}
