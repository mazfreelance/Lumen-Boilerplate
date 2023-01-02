<?php

namespace App\Containers\v1\User\Actions;

use Illuminate\Support\Facades\Auth;

class GetMeAction
{
    public function execute()
    {
        return Auth::user();
    }
}
