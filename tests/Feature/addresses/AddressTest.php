<?php

namespace Tests\Feature\addresses;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\addresses\App\Models\Address;

class AddressTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getUserForTest();
    }

    public function test_create(): void
    {
        $data = Address::factory()->make();
        $response = $this->actingAs($this->user)->post('api/user/address/create', [
            'address' => $data->address,
            'plaque' => $data->plaque,
            'postal_code' => $data->postal_code,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'recipient_name' => $data->recipient_name,
            'recipient_last_name' => $data->recipient_last_name,
            'recipient_mobile_number' => $data->recipient_mobile_number,
            'province_id' => 1,
            'city_id' => 1,
        ]);
        //
        $this->assertDatabaseHas('users__addresses', $data->toArray());
        $response->assertOk();
    }

    public function test_update(): void
    {
        $data = Address::factory()->make();
        $address = Address::factory()->create([
            'province_id' => 1,
            'city_id' => 1,
            'user_id' => $this->user->id,
        ]);
        $response = $this->actingAs($this->user)->put("api/user/address/{$address->id}/update", [
            'address' => $data->address,
            'plaque' => $data->plaque,
            'postal_code' => $data->postal_code,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'recipient_name' => $data->recipient_name,
            'recipient_last_name' => $data->recipient_last_name,
            'recipient_mobile_number' => $data->recipient_mobile_number,
            'province_id' => 1,
            'city_id' => 1,
        ]);
        //
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/user/addresses');
        $body = json_decode($response->getContent(), true);
        $count = Address::where('user_id', $this->user->id)->count();
        $this->assertEquals($count, sizeof($body));
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $address = Address::factory()->create([
            'province_id' => 1,
            'city_id' => 1,
            'user_id' => $this->user->id,
        ]);
        $response = $this->actingAs($this->user)
            ->delete("api/user/address/{$address->id}/delete");
        $this->assertDatabaseMissing('users__addresses', [
            'id' => $address->id,
            'deleted_at' => null
        ]);
        $response->assertOk();
    }
}
