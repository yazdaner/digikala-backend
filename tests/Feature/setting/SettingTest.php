<?php

namespace Tests\Feature\setting;

use Tests\TestCase;
use Modules\users\App\Models\User;

class SettingTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_web_service_setting(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/setting/web-services', [
            'gateway' => 'zarinpal',
        ]);
        $response->assertOk();
    }
    public function test_add_web_service_info(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/setting/web-services');
        $data = $response->json();
        $this->assertArrayHasKey('gateway',$data);
        $this->assertNotNull($data['gateway']);
        $response->assertOk();
    }
}
