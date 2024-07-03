<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\cart\App\Models\Order;
use Modules\users\App\Models\User;

class AdminOrderTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function  test_order_list(): void
    {
        $response = $this->actingAs($this->user)->get("/api/admin/orders");
        $body = $response->json();
        $this->assertGreaterThan(0,sizeof($body['orders']['data']));
        $response->assertOk();
    }

    
    public function test_destroy(): void
    {
        $order = Order::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->delete('api/admin/orders/' . $order->id);
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $order = Order::onlyTrashed()->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->post('api/admin/orders/' . $order->id . '/restore');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_order_info(): void
    {
        $order = Order::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->get("/api/admin/order/{$order->id}/info");
        $this->assertGreaterThan(0,sizeof($response->json()['submissions']));
        $this->assertGreaterThan(0,sizeof($response->json()['submissions'][0]['items']));
        $response->assertOk();
    }
}
