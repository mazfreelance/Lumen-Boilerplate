<?php

namespace App\Containers\v1\User\Actions;

use Illuminate\Http\Request;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\Auth;
use App\Containers\v1\User\Jobs\ExportUserList;

class ExportAction
{
    public function execute(Request $request)
    {
        // Helper::hasAnyPermission('user.export');

        dispatch(new ExportUserList($request->toArray(), Auth::user()));
    }
}
