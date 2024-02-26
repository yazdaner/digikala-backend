<?php

namespace Tests\Feature\areas;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\users\App\Models\User;
use Modules\areas\App\Models\Province;

class ProvinceTest extends TestCase
{
    protected User|null $admin = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }

    public function test_create(): void
    {
        $province = Province::factory()->make();
        $response = $this->actingAs($this->admin)->post('api/admin/provinces', [
            'name' => $province->name,
        ]);
        $province = Province::latest()->first();
        //
        $this->assertNotNull($province->name);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->admin)->get('api/admin/provinces');
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('provinces', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->admin)->get('api/admin/provinces?trashed=true&name=app');
        $body = json_decode($response->getContent(), true);
        $count = Province::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['provinces']['total'], $count);
        $this->assertArrayHasKey('provinces', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $province = Province::factory()->create();
        $response = $this->actingAs($this->admin)->get('api/admin/provinces/' . $province->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($province->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(10);
        $province = Province::factory()->create();
        $response = $this->actingAs($this->admin)->put('api/admin/provinces/' . $province->id, [
            'name' => $name,
        ]);
        //
        $this->assertDatabaseHas('provinces', [
            'id' => $province->id,
            'name' => $name,
        ]);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $province = Province::factory()->create();
        $response = $this->actingAs($this->admin)->delete('api/admin/provinces/' . $province->id);
        $this->assertDatabaseMissing('provinces', [
            'id' => $province->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $province = Province::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($this->admin)->post('api/admin/provinces/' . $province->id . '/restore');
        $this->assertDatabaseHas('provinces', [
            'id' => $province->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/provinces/all');
        $body = json_decode($response->getContent(), true);
        $provinces = Province::get();
        $this->assertEquals(sizeof($provinces), sizeof($body));
        $response->assertOk();
    }
}
