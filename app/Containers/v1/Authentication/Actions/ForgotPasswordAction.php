<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\ForgotPasswordDTO;
use App\Containers\v1\Authentication\Models\PasswordReset;
use App\Containers\v1\User\Models\User;
use App\Ship\Exceptions\GeneralHttpException;
use App\Ship\Mail\SendResetPasswordToken;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordAction
{
    public function execute(ForgotPasswordDTO $forgotPasswordDTO)
    {
        DB::transaction(function () use ($forgotPasswordDTO) {
            $user = User::where('email', $forgotPasswordDTO->email)->first();

            if (!$user) throw new GeneralHttpException(__('message.user_not_found'));

            $token = Helper::generatePasswordResetToken();

            PasswordReset::create(array_merge($forgotPasswordDTO->toArray(), [
                'token' => $token,
                'expired_at' => Carbon::now()->addHours(1)
            ]));
            Mail::to($forgotPasswordDTO->email)->send(new SendResetPasswordToken($token, $user));
        });
    }
}
