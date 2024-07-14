<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\sellers\App\Models\Seller;
use Illuminate\Validation\ValidationException;
use Modules\sellers\App\Actions\RegisterSeller;
use Modules\sellers\App\Http\Requests\LoginRequest;

class AuthenticationContoller extends Controller
{
    public function signIn(Request $request, RegisterSeller $registerSeller)
    {
        $username = $request->get('username');
        $seller = Seller::where('username', $username)->first();
        if ($seller && $seller->status >= -1) {
            return ['status' => 'login'];
        } else {
            $registerSeller($request);
            return ['status' => 'register'];
        }
    }

    public function login(LoginRequest $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $seller = Seller::where('username', $username)
            ->where('status', '>=', -1)
            ->first();
        if ($seller && Hash::check($password, $seller->password)) {
            Auth::guard('seller')->login($seller);
            return ['status' => 'ok'];
        }
        throw ValidationException::withMessages([
            'error' => 'نام کاربری یا کلمه عبور اشتباه می باشد'
        ]);
    }

    public function logout()
    {
        Auth::guard('seller')->logout();
    }
}
