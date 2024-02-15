<?php

namespace Modules\users\App\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\users\App\Models\User;
use Modules\core\App\Models\VerificationCode;
use Modules\core\App\Jobs\SendVerificationCode;

class SendAuthVerifyCode
{
    public function __invoke($user)
    {
        if ($user->status == -1) {
            $this->sendVerifyCode($user);
        } else {
            $this->sendOneTimePassword($user);
        }
    }

    protected function sendVerifyCode($user)
    {
        $code = rand(10000, 99999);
        VerificationCode::create([
            'tableable_type' => User::class,
            'tableable_id' => $user->id,
            'code' => $code,
        ]);
        SendVerificationCode::dispatch(
            $user->username,
            $code,
            null,
            config('users.verify_template'),
        )->onConnection('database');
    }

    protected function sendOneTimePassword($user)
    {
        $code = rand(10000, 99999);
        $user->password = Hash::make($code);
        $user->update();
        SendVerificationCode::dispatch(
            $user->username,
            $code,
            null,
            config('users.verify_template'),
        )->onConnection('database');
    }
}
