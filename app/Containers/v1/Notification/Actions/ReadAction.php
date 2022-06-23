<?php

namespace App\Containers\v1\Notification\Actions;

use App\Containers\v1\User\Models\User;
use Illuminate\Support\Facades\Auth;

class ReadAction
{
    public function execute(string $id)
    {
        $user = $this->getUser();
        $user->markAsRead([$id]);
    }

    private function getUser(): User
    {
        return User::find(Auth::id());
    }
}
