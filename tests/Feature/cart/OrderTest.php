<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\users\App\Models\User;

class OrderTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function  test_return_submission_info(): void
    {
        $address = runEvent('address-detail', ['user_id' => $this->user->id], true);
        $response = $this->actingAs($this->user)->get("/api/user/card/submissions?address_id=$address->id");
        $body = json_decode($response->getContent(),true);
        $this->assertGreaterThan(0,sizeof($body['submission']));
        $response->assertStatus(200);
    }

    public function  test_add_order(): void
    {
        $address = runEvent('address-detail', ['user_id' => $this->user->id], true);
        \Log::info($address);
        $response = $this->actingAs($this->user)->post('/api/user/add-order',[
            'address_id' => $address->id,
            'payment_method' => 'online-payment'
        ]);
        // $body = json_decode($response->getContent(),true);
        $response->assertStatus(200);
    }
}
