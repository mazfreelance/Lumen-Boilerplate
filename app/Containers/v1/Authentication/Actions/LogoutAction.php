<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\User\Enums\UserOnlineStatus;
use App\Containers\v1\User\Models\User;

class LogoutAction
{
    public function execute()
    {
        $user = auth()->user();
        $this->updateUser($user);
        $this->revokeToken($user);
    }

    private function updateUser(User $user): void
    {
        $user->online_status = UserOnlineStatus::Offline();
        if ($user->isDirty()) {
            $user->save();
        }
    }

    private function revokeToken(User $user): void
    {
        $token = $user->token();
        $user->revokeRefreshToken($token->id);
        $token->revoke();
    }
}
