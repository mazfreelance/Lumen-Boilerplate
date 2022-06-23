<?php

namespace App\Containers\v1\Notification\Actions;

use App\Containers\v1\Notification\Models\Notification;
use App\Containers\v1\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetAllAction
{
    public function execute(Request $request, int $pageSize)
    {
        $filterData = $request->toArray();
        $filterData['notifiable'] = Auth::id();
        $filterData['notifiable_type'] = User::class;

        return  Notification::filter($filterData)->latest()->paginate($pageSize);
    }
}
