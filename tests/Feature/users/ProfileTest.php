<?php

namespace Tests\Feature\users;

use Tests\TestCase;

class ProfileTest extends TestCase
{

    public function test_update_password(): void
    {
        $user = getUserForTest();
        $current_password = fake()->password(8);
        $new_password = fake()->password(10);
        $user->password = $current_password;
        $user->update();
        $response = $this->actingAs($user)->post('api/user/profile/update-password', [
            'current_password' => $current_password,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ]);
        $response->assertOk();
    }

    // web login mode
    public function test_login(): void
    {
        $user = getUserForTest();
        $current_password = fake()->password(8);
        $user->password = $current_password;
        $user->update();

        $response = $this->post('login', [
            'username' => $user->username,
            'password' => $current_password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    // application login mode
    public function test_login_2(): void
    {
        $user = getUserForTest();
        $current_password = fake()->password(8);
        $user->password = $current_password;
        $user->update();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('login', [
            'username' => $user->username,
            'password' => $current_password,
        ]);

        $body = json_decode($response->getContent(),true);
        $this->assertArrayHasKey('two_factor',$body);
        $response->assertOk();
    }
}
