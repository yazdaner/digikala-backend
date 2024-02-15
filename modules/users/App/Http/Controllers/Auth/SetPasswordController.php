<?php

namespace Modules\users\App\Http\Controllers\Auth;

use Modules\users\App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\users\App\Http\Requests\SignUpRequest;

class SetPasswordController extends Controller
{
    public function __invoke(SignUpRequest $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $encrypt = $request->get('encrypt');

        $decrypt = $this->decryptToken($encrypt);
        $decryptedUsername = $this->getEncryptUsername($decrypt);
        $decryptedTime = $this->getEncryptTime($decrypt);

        if ($username == $decryptedUsername && (time() - $decryptedTime) <= (30 * 60)) {
            $user = User::where([
                'username' => $request->get($username),
                'role' => 'user',
                'status' => -1,
            ])->firstOrFail();
            $user->password = Hash::make($password);
            $user->status = 1;
            $user->update();
            Auth::login($user);
            return ['status' => 'logged'];
        } else {
            return ['status' => 'error', 'message' => 'حساب کاربری معتبر نمی باشد'];
        }
    }

    protected function decryptToken($encrypt)
    {
        $decrypt = decrypt($encrypt);
        $decrypt = str_replace('$$', '', $decrypt);
        $decrypt = str_replace('%%', '', $decrypt);
        return $decrypt;
    }

    protected function getEncryptUsername($decrypt)
    {
        $ar = explode(':', $decrypt);
        return str_replace(':' . $ar[sizeof($ar) - 1], '', $decrypt);
    }

    protected function getEncryptTime($decrypt)
    {
        $ar = explode(':', $decrypt);
        return $ar[sizeof($ar) - 1];
    }
}
