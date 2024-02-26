<?php

namespace Tests\Feature\areas;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\areas\App\Models\City;

class CityTest extends TestCase
{
    public function test_create(): void
    {
        $admin = getAdminForTest();
        $city = City::factory()->make();
        $response = $this->actingAs($admin)->post('api/admin/cities', [
            'name' => $city->name,
            'province_id' => $city->province_id,
        ]);
        $city = City::latest()->first();
        //
        $this->assertNotNull($city->name);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/cities');
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('cities', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/cities?trashed=true&name=app');
        $body = json_decode($response->getContent(), true);
        $count = City::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['cities']['total'], $count);
        $this->assertArrayHasKey('cities', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $admin = getAdminForTest();
        $city = City::factory()->create();
        $response = $this->actingAs($admin)->get('api/admin/cities/' . $city->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($city->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $name = Str::random(10);
        $city = City::factory()->create();
        $response = $this->actingAs($admin)->put('api/admin/cities/' . $city->id, [
            'name' => $name,
            'province_id' => $city->province_id,
        ]);
        //
        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'name' => $name,
        ]);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $admin = getAdminForTest();
        $city = City::factory()->create();
        $response = $this->actingAs($admin)->delete('api/admin/cities/' . $city->id);
        $this->assertDatabaseMissing('cities', [
            'id' => $city->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $city = City::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($admin)->post('api/admin/cities/' . $city->id . '/restore');
        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/cities/all');
        $body = json_decode($response->getContent(), true);
        $cities = City::get();
        $this->assertEquals(sizeof($cities), sizeof($body));
        $response->assertOk();
    }
}
