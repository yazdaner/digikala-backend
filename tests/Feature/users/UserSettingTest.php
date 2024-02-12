<?php

namespace Tests\Feature\users;

use Tests\TestCase;

class UserSettingTest extends TestCase
{
    public function test_set_config_setting(): void
    {
        $response = $this->post('api/admin/setting/users',[
            'verify_template' => 'verify_code',
            'password_template' => 'verify_code',
            'register_format' => 'email-mobile',
            'one_time_password' => 'false',
        ]);
        //
        $response->assertOk();
    }

    public function test_get_config_setting(): void
    {
        $response = $this->get('api/admin/setting/users');
        $body = json_decode($response->getContent(),true);
        $usersConfig= config('users');
        $this->assertEquals($body['verify_template'],$usersConfig['verify_template']);
        //
        $response->assertOk();
    }
}
