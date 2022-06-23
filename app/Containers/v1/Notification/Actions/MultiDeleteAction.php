<?php

namespace App\Containers\v1\Notification\Actions;

use App\Containers\v1\Notification\DTO\NotificationStoreDTO;
use App\Containers\v1\User\Models\User;
use Illuminate\Support\Facades\Auth;

class MultiDeleteAction
{
    public function execute(NotificationStoreDTO $notificationStoreDTO) : void
    {
        $user = $this->getUser();
        $user->notifications()->whereIn('id', $notificationStoreDTO->notification_ids)->delete();
    }

    private function getUser(): User
    {
        return User::find(Auth::id());
    }
}
