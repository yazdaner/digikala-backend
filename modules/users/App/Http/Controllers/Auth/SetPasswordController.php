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
    }
}
