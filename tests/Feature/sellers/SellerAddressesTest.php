<?php

namespace Tests\Feature\sellers;

use Tests\TestCase;
use Modules\sellers\App\Models\Seller;
use Modules\sellers\App\Models\SellerAddress;

class SellerAddressesTest extends TestCase
{
    protected Seller $seller;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::inRandomOrder()->first();
    }

    public function test_create(): void
    {
        $data = SellerAddress::factory()->make([
            'warehouse' => 'true',
            'warehouse_name' => 'test',
        ])->toArray();
        $response = $this->actingAs($this->seller, 'seller')
            ->post('api/seller/profile/address', $data);
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_list(): void
    {
        $response = $this->actingAs($this->seller, 'seller')
            ->get('api/seller/profile/addresses?type=warehouse');
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertOk();
    }

    public function test_update(): void
    {
        $text = fake()->paragraph();
        $address = SellerAddress::inRandomOrder()->first();
        $data = $address->toArray();
        $data['address'] = $text;
        $response = $this->actingAs($this->seller, 'seller')
            ->put('api/seller/profile/address/' . $address->id, $data);
        $this->assertDatabaseHas('sellers__address', [
            'id' => $address->id,
            'address' => $text
        ]);
        $response->assertOk()->assertJson(['status' => 'ok']);
    }

}
