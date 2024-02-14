<?php

namespace Modules\users\App\Actions\Fortify;

use Illuminate\Http\Request;
use Modules\users\App\Models\User;

class CreateNewUser
{
    public function __invoke(Request $request)
    {
        return User::create([
            'username' => $request->get('username'),
            'role' => 'user',
            'status' => -2,
        ]);
    }
}
