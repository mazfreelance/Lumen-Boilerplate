<?php

namespace App\Containers\v1\User\Actions;

use App\Containers\v1\User\Resources\Profile;
use Illuminate\Support\Facades\Auth;

class GetMeAction
{
    public function execute()
    {
        return new Profile(Auth::user());
    }
}
