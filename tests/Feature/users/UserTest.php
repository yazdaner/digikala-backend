<?php

namespace Tests\Feature\users;

use Modules\core\App\Models\VerificationCode;
use Tests\TestCase;
use Modules\users\App\Models\User;

class UserTest extends TestCase
{

    protected function makeUser()
    {
        $this->post('api/user/check-has-account', [
            'username' => fake()->email()
        ]);
    }

    // when user register for first time with email
    public function test_check_has_account(): void
    {
        $response = $this->post('api/user/check-has-account', [
            'username' => fake()->email()
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals('verify-username', $body['status']);
        $response->assertOk();
    }

    public function test_check_one_time_password(): void
    {
        config()->set('users.one_time_password', true);
        $user = User::orderBy('id', 'DESC')->first();
        $response = $this->post('api/user/check-has-account', [
            'username' => $user->username
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals('verify-username', $body['status']);
        $response->assertOk();
    }

    // verify code and then go to set password - one time password is false
    public function test_check_verify_account_1()
    {
        $user = User::orderBy('id', 'DESC')->first();
        $verification = VerificationCode::where([
            'tableable_type' => User::class,
            'tableable_id' => $user->id
        ])->first();

        $response = $this->post('api/user/check/verify-code', [
            'username' => $user->username,
            'code' => $verification->code,
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('encrypt', $body);
        $this->assertEquals('set-password', $body['status']);
        $response->assertOk();
    }

    // set password after verify code
     public function test_check_set_password()
     {
         $user = User::orderBy('id','DESC')->first();
         $encrypt = encrypt('$$'.$user->username.':'.time().'%%');
         $password = fake()->password(9);

         $response = $this->post('api/user/account/set-password',[
             'username' => $user->username,
             'password' => $password,
             'encrypt' => $encrypt,
         ]);
         $body = json_decode($response->getContent(),true);
         $this->assertEquals('logged',$body['status']);
         $response->assertOk();
     }

      // verify code and then go to set password - one time password is true
    public function test_check_verify_account_2()
    {
        $this->makeUser();
        config()->set('users.one_time_password', true);
        $user = User::orderBy('id', 'DESC')->first();
        $verification = VerificationCode::where([
            'tableable_type' => User::class,
            'tableable_id' => $user->id
        ])->first();

        $response = $this->post('api/user/check/verify-code', [
            'username' => $user->username,
            'code' => $verification->code,
        ]);

        $body = json_decode($response->getContent(), true);
        $this->assertEquals('logged', $body['status']);
        $response->assertOk();
    }
}
