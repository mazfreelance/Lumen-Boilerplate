<?php

namespace App\Containers\v1\Notification\Actions;

use App\Containers\v1\Notification\DTO\NotificationStoreDTO;
use App\Containers\v1\User\Models\User;
use Illuminate\Support\Facades\Auth;

class MultiReadAction
{
    public function execute(NotificationStoreDTO $notificationStoreDTO)
    {
        $user = $this->getUser();
        $user->markAsRead($notificationStoreDTO->notification_ids);
    }

    private function getUser(): User
    {
        return User::find(Auth::id());
    }
}
