<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\cart\App\Models\Order;
use Modules\users\App\Models\User;

class CompanySettingTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_update_setting(): void
    {
        $response = $this->actingAs($this->user)->post("/api/admin/order/setting/company",[
            'name' => 'yazdan company',
            'national_id' => '123456789',
            'registration_number' => '123456789',
            'economical_number' => '12345',
            'postal_number' => '1234567890',
            'phone' => '09123456789',
            'address' => 'test address',
        ]);
        $response->assertOk();
    }

    public function test_get_setting(): void
    {
        $response = $this->actingAs($this->user)->get("/api/order/setting/company");
        $body = $response->json();
        $this->assertEquals($body['phone'],'09123456789');
        $response->assertOk();
    }
}
