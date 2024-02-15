<?php

namespace Tests\Feature\users;

use Tests\TestCase;
use Modules\users\App\Models\User;

class UserTest extends TestCase
{
    // when user register for first time with email
    public function test_check_has_account(): void
    {
        $username = fake()->email();
        $response = $this->post('api/user/check-has-account',[
            'username' => $username
        ]);
        $body = json_decode($response->getContent(),true);
        $this->assertEquals('verify-username',$body['status']);
        $response->assertOk();
    }

    // public function test_check_one_time_password(): void
    // {
    //     config()->set('users.one_time_password',true);
    //     $user = User::orderBy('id','DESC')->first();
    //     $response = $this->post('api/user/check-has-account',[
    //         'username' => $user->username
    //     ]);
    //     $body = json_decode($response->getContent(),true);
    //     $this->assertEquals('verify-username',$body['status']);
    //     $response->assertOk();
    // }

    public function test_check_verify_account()
    {
        $response = $this->post('api/user/check/verify-code',[
            'username' => $user->username
        ]);
    }
}
