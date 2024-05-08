<?php

namespace Tests\Feature\users;

use Tests\TestCase;
use Modules\users\App\Models\User;

class ProfileTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getUserForTest();
    }

    public function test_update_password(): void
    {
        $current_password = fake()->password(8);
        $new_password = fake()->password(10);
        $this->user->password = $current_password;
        $this->user->update();
        $response = $this->actingAs($this->user)->post('api/user/profile/update-password', [
            'current_password' => $current_password,
            'password' => $new_password,
            'password_confirmation' => $new_password,
        ]);
        $response->assertOk();
    }

    // web login mode
    public function test_login(): void
    {
        $current_password = fake()->password(8);
        $this->user->password = $current_password;
        $this->user->update();

        $response = $this->post('login', [
            'username' => $this->user->username,
            'password' => $current_password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($this->user);
    }

    // application login mode
    public function test_login_2(): void
    {
        $current_password = fake()->password(8);
        $this->user->password = $current_password;
        $this->user->update();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('login', [
            'username' => $this->user->username,
            'password' => $current_password,
        ]);

        $body = json_decode($response->getContent(),true);
        $this->assertArrayHasKey('two_factor',$body);
        $response->assertOk();
    }
}
