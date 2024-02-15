<?php

use Illuminate\Support\Facades\Hash;
use Modules\users\App\Models\User;

function getAdminForTest()
{
    $user = User::where([
        'role' => 'admin',
        'status' => 1
    ])->first();
    if ($user) {
        return $user;
    } else {
        return User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'status' => 1
        ]);
    }
}


function getUserForTest()
{
    $user = User::where([
        'role' => 'user',
        'status' => 1
    ])->first();
    if ($user) {
        return $user;
    } else {
        return User::create([
            'username' => 'user',
            'password' => Hash::make('user'),
            'role' => 'user',
            'status' => 1
        ]);
    }
}
