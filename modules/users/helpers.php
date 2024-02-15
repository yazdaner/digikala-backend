<?php

use Illuminate\Support\Facades\Hash;
use Modules\users\App\Models\User;

function getAdminForTest()
{
    $user = User::where([
        'role' => 'admin'
    ])->first();
    if($user){
        return $user;
    }else{
        return User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'status' => 1
        ]);
    }
}
