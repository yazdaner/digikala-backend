<?php

namespace Modules\users\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\users\App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use Modules\core\App\Models\VerificationCode;

class CheckVerifyCodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $code = trim($request->get('code'));
        $type = $request->get('type');
        $username = $request->get('username');
        $user = User::where(['username' => $username, 'role' => 'user'])->firstOrFail();
        $verification = VerificationCode::where([
            'tableable_type' => User::class,
            'tableable_id' => $user->id,
            'code' => $code
        ])->first();
        if ($verification) {
            $verification->delete();
            if ($type == 'forget-password') {
                $token = $this->broker()->sendResetLink(
                    $request->only('username')
                );
                return ['status' => 'ok', 'token' => $token];
            } else {
                return $this->checkLoginConditions($user, $code);
            }
        }
        return ['status' => 'error', 'message' => 'کد تایید وارد شده اشتباه می باشد'];
    }
    protected function checkLoginConditions($user, $code)
    {
        $one_time_password = config('users.one_time_password');
        if ($one_time_password == 'true') {
            if ($user->status == -2) {
                $user->status = 1;
                $user->update();
            }
            Auth::login($user);
            return ['status' => 'logged'];
        } else {
            $user->status = -1;
            $user->update();
            return ['status' => 'set-password'];
        }
    }

    protected function broker () : PasswordBroker
    {
        return Password::broker(
            config('fortify.passwords')
        );
    }
}
