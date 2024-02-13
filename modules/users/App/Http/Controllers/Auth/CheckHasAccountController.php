<?php

namespace Modules\users\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\users\App\Models\User;

use App\Http\Controllers\Controller;
use Modules\users\App\Http\Actions\CreateNewUser;
use Modules\users\App\Http\Actions\SendAuthVerifyCode;

class CheckHasAccountController extends Controller
{
    public function __invoke(
        Request $request,
        CreateNewUser $createNewUser,
        SendAuthVerifyCode $sendAuthVerifyCode
    ) {
        $username = $request->get('username');
        $user = User::where([
            'username' => $username,
            'role' => 'user',
        ])->first();
        $status = 'verify-username';
        if ($user) {
            if ($user->status == -1) {
                $sendAuthVerifyCode($user);
            } else {
                $oneTimePassword = config('users.one_time_password');
                if ($oneTimePassword == 'true') {
                    $status = 'one_time_password';
                    $sendAuthVerifyCode($user);
                } else {
                    $status = 'check-password';
                }
            }
        } else {
            $user = $createNewUser();
            $sendAuthVerifyCode($user);
        }
        return ['status' => $status];
    }
}
