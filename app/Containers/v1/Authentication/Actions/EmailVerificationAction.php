<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\EmailVerificationDTO;
use App\Containers\v1\Notification\Notifications\ActionUpdate;
use App\Containers\v1\User\Enums\UserVerifyStatus;
use App\Containers\v1\User\Models\User;
use App\Ship\Mail\SendWelcome;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailVerificationAction
{
    public function execute(EmailVerificationDTO $emailVerificationDTO)
    {
        DB::transaction( function () use ($emailVerificationDTO) {
            $user = User::where('verification_token', $emailVerificationDTO->token)->lockForUpdate()->firstOrFail();

            $user->update([
                'verification_token' => null,
                'verify_status' => UserVerifyStatus::Yes,
                'email_verified_at' => Carbon::now()
            ]);

            if (!$this->isChangeEmail($emailVerificationDTO->token)) {
                $name = config('app.name');
                $title = [
                    "en" => "Welcome to {$name}!"
                ];
                $message = [
                    "en" => "Your account has been confirmed successfully.",
                ];

                $user->notify(new ActionUpdate($title['en'], $message['en']));

                $this->sendWelcome($user);
            }
        });
    }

    private function isChangeEmail(string $token): bool
    {
        return str_contains($token, 'update');
    }

    private function sendWelcome(User $user): void
    {
        Mail::to($user->email)->send(new SendWelcome($user));
    }
}
