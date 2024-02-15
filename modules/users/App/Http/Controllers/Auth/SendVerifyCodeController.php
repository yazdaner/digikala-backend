<?php

namespace Modules\users\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\users\App\Models\User;
use App\Http\Controllers\Controller;
use Modules\core\App\Models\VerificationCode;
use Modules\core\App\Jobs\SendVerificationCode;

class SendVerifyCodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $username = $request->post('username');
        $user = User::where(['username' => $username])->firstOrFail();
        $code = rand(10000, 99999);
        VerificationCode::create([
            'tableable_type' => User::class,
            'tableable_id' => $user->id,
            'code' => $code
        ]);
        SendVerificationCode::dispatch(
            $user->username,
            $code,
            null,
            config('users.verify_template')
        )->onConnection('database');
        return ['status' => 'ok'];
    }
}
