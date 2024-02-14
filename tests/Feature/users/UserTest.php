<?php

namespace Tests\Feature\users;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_check_has_account(): void
    {
        $username = fake()->email();
        $response = $this->post('api/user/check-has-account',[
            'username' => $username
        ]);
        \Log::info($response->getContent());
        $response->assertOk();
    }
}
