<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\DTO\ChangePasswordDTO;
use App\Containers\v1\User\Models\User;
use Illuminate\Support\Facades\{Auth, DB, Hash};

class ChangePasswordAction
{
    public function execute(ChangePasswordDTO $changePasswordDTO)
    {
        DB::transaction(function () use ($changePasswordDTO) {
            $user = $this->getUser();
            $user->update(['password' => Hash::make($changePasswordDTO->new_password)]);
            $user->revokeAllToken($user->token());
        });
    }

    private function getUser(): User
    {
        return Auth::user();
    }
}
