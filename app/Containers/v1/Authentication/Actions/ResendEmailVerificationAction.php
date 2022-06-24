<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\ResendEmailVerificationDTO;
use App\Containers\v1\User\Enums\UserVerifyStatus;
use App\Containers\v1\User\Models\User;
use App\Ship\Mail\SendEmailVerification;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResendEmailVerificationAction
{
    public function execute(ResendEmailVerificationDTO $resendEmailVerificationDTO)
    {
        $user = $this->getUser();

        $this->hasVerified($user);


        $email = $resendEmailVerificationDTO->email ? $resendEmailVerificationDTO->email : $user->email;

        $user->update([
            'email' => $email,
            'email_verified_at' => null
        ]);

        Mail::to($email)->send(new SendEmailVerification($user->verification_token, $user));

        return Helper::maskEmail($email);
    }

    private function getUser(): User
    {
        return Auth::user();
    }

    private function hasVerified(User $user): void
    {
        if ($user->verify_status->value == UserVerifyStatus::Yes) {
            throw new BadRequestException(__('message.user_email_verified'));
        }
    }
}
