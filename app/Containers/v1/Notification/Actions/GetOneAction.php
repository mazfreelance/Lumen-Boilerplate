<?php

namespace App\Containers\v1\Notification\Actions;

use App\Containers\v1\Notification\Models\Notification;
use App\Containers\v1\User\Models\User;
use Illuminate\Support\Facades\Auth;

class GetOneAction
{
    public function execute(string $id)
    {
        return $notification = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->findOrFail($id);
    }
}
