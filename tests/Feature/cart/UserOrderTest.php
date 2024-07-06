<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\users\App\Models\User;

class UserOrderTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function  test_orders_list(): void
    {
        $response = $this->actingAs($this->user)->get('/api/user/orders?status=current');
        // \Log::info($response->json());
        $this->assertGreaterThan(0,sizeof($response->json()));
        $response->assertOk();
    }

    public function  test_orders_statistics(): void
    {
        $response = $this->actingAs($this->user)->get('/api/user/orders/statistics');
        // \Log::info($response->json());
        $this->assertArrayHasKey('current',$response->json());
        $this->assertGreaterThan(0,$response->json()['current']);
        $response->assertOk();
    }
}
