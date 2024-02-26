<?php

namespace Tests\Feature\brands;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\brands\App\Models\Brand;

class BrandTest extends TestCase
{
    public function test_create(): void
    {
        $admin = getAdminForTest();
        $brand = Brand::factory()->make();
        $response = $this->actingAs($admin)->post('api/admin/brands', [
            'name' => $brand->name,
            'en_name' => $brand->en_name,
            'icon' => UploadedFile::fake()->image('icon.png'),
        ]);
        $brand = Brand::latest()->first();
        //
        $this->assertNotNull($brand->icon);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/brands');
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('brands', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/brands?trashed=true&name=app');
        $body = json_decode($response->getContent(), true);
        $count = Brand::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['brands']['total'], $count);
        $this->assertArrayHasKey('brands', $body);
        $response->assertOk();
    }
    public function test_show(): void
    {
        $admin = getAdminForTest();
        $brand = Brand::factory()->create();
        $response = $this->actingAs($admin)->get('api/admin/brands/' . $brand->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($brand->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $name = Str::random(10);
        $en_name = Str::random(10);
        $brand = Brand::factory()->create();
        $response = $this->actingAs($admin)->put('api/admin/brands/' . $brand->id, [
            'name' => $name,
            'en_name' => $en_name,
        ]);
        //
        $this->assertDatabaseHas('products__brands', [
            'id' => $brand->id,
            'name' => $name,
            'en_name' => $en_name,
        ]);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $admin = getAdminForTest();
        $brand = Brand::factory()->create();
        $response = $this->actingAs($admin)->delete('api/admin/brands/' . $brand->id);
        $this->assertDatabaseMissing('products__brands', [
            'id' => $brand->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $brand = Brand::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($admin)->post('api/admin/brands/' . $brand->id . '/restore');
        $this->assertDatabaseHas('products__brands', [
            'id' => $brand->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/brands/all');
        $body = json_decode($response->getContent(), true);
        $brands = Brand::get();
        $this->assertEquals(sizeof($brands), sizeof($body));
        $response->assertOk();
    }
}
