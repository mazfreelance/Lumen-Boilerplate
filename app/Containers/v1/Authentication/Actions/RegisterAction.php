<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\RegisterDTO;
use App\Containers\v1\Notification\Notifications\ActionUpdate;
use App\Containers\v1\User\Enums\{UserStatus, UserVerifyStatus};
use App\Containers\v1\User\Models\User;
use App\Ship\Mail\SendEmailVerification;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\{DB, Hash, Mail};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RegisterAction
{
    public function execute(RegisterDTO $registerDTO)
    {
        DB::transaction(function () use ($registerDTO){

            $user = $this->createUser($registerDTO);
            $this->syncUserPermission($user);
            $this->sendEmailVerification($user);
            $this->sendNotification($user);
        });
    }

    private function createUser(RegisterDTO $registerDTO): User
    {
        return User::create(array_merge($registerDTO->only('name', 'email')->toArray(), [
            'password' => Hash::make($registerDTO->password),
            'verification_token' => Helper::generateVerificationToken(),
            'status' => UserStatus::Active,
            'verify_status' => UserVerifyStatus::No
        ]));
    }

    private function syncUserPermission(User $user): void
    {
        $permissions = Role::findByName('user')->permissions()->get();
        $user->assignRole('user');
        $user->syncPermissions($permissions);
    }

    private function sendEmailVerification(User $user): void
    {
        Mail::to($user->email)->send(new SendEmailVerification($user->verification_token, $user));
    }

    private function sendNotification(User $user): void
    {
        $name = config('app.name');
        $title = [
            "en" => "You are so close to get into {$name}!"
        ];
        $message = [
            "en" => "Thank you for your interest to join us at {$name}. Now, you only have to verify your email. Go now!"
        ];

        $user->notify(new ActionUpdate($title['en'], $message['en']));
    }
}
