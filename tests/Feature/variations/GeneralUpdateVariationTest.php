<?php

namespace Tests\Feature\variations;

use Tests\TestCase;
use Illuminate\Foundation\Auth\User;

class GeneralUpdateVariationTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_update_price(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/variations/general-update', [
            'amount' => 10000
        ]);
        //
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_update_count(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/variations/general-update', [
            'amount' => 2,
            'column' => 'product_count',
        ]);
        //
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
