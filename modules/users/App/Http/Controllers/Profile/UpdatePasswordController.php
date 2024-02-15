<?php

namespace Modules\users\App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\users\App\Http\Requests\UpdatePasswordRequest;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request)
    {
        $current_password = $request->post('current_password');
        $user = $request->user();
        if(Hash::check($current_password,$user->password)){
            $user->password = Hash::make($request->post('password'));
            $user->update();
            return ['status' => 'ok'];
        }else{
            throw ValidationException::withMessages([
                'password' => 'کلمه عبور اشتباه می باشند'
            ]);
        }
    }
}
