<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\ResetPasswordDTO;
use App\Containers\v1\Authentication\Models\PasswordReset;
use App\Containers\v1\User\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResetPasswordAction
{
    public function execute(ResetPasswordDTO $resetPasswordDTO)
    {
        DB::transaction(function () use ($resetPasswordDTO) {
            $passwordReset = $this->getPasswordReset($resetPasswordDTO->token);
            $user = User::where('email', $passwordReset->email)->firstOrFail();
            $user->update([
                'password' => Hash::make($resetPasswordDTO->password)
            ]);
            $user->revokeAllToken();
            $passwordReset->where('token', $resetPasswordDTO->token)->delete();
        });
    }

    private function getPasswordReset(string $token): PasswordReset
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            throw new BadRequestException(__('message.invalid_reset_token'));
        }

        $this->hasTokenExpired($passwordReset);

        return $passwordReset;
    }

    private function hasTokenExpired(PasswordReset $passwordReset): void
    {
        if ($passwordReset->expired_at <= Carbon::now()) {
            throw new BadRequestException(__('message.token_expired'));
        }
    }
}
