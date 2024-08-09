<?php

namespace Tests\Feature\zarinpal;

use Tests\TestCase;
use Modules\users\App\Models\User;

class ZarinpalTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_setting(): void
    {
        $response = $this->actingAs($this->user)
            ->post('api/admin/setting/gateway/zarinpal', [
                'MerchantId' => fake()->text()
            ]);
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_get_setting(): void
    {
        $response = $this->actingAs($this->user)
            ->get('api/admin/setting/gateway/zarinpal');
            $this->assertNotNull($response->json()['MerchantId']);
        $response->assertOk();
    }
}
