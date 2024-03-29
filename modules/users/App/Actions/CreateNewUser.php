<?php

namespace Modules\users\App\Actions;

use Illuminate\Http\Request;
use Modules\users\App\Models\User;

class CreateNewUser
{
    public function __invoke(Request $request)
    {
        return User::create([
            'username' => $request->get('username'),
            'role' => 'user',
            'status' => -1,
            'password' => rand(999,9999).$request->get('username').'@#$'.rand(999,9999)
        ]);
    }
}
