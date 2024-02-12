<?php

namespace Modules\users\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\users\App\Http\Actions\AddUserSetting;

class UserSettingController extends Controller
{
    public function __invoke(Request $request, AddUserSetting $addUserSetting)
    {
        if ($request->isMethod('post')) {
            $addUserSetting($request);
            return ['status' => 'ok'];
        } else {
            return config('users');
        }
    }
}
