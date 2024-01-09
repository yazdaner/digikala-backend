<?php

namespace Tests\Feature\brand;

use Illuminate\Http\UploadedFile;
use Modules\brands\App\Models\Brand;
use Tests\TestCase;

class BrandTest extends TestCase
{
    public function test_store_validate(): void
    {
        $response = $this->post('api/admin/brands',[]);
        //
        $response->assertSessionHasErrors()
        ->assertStatus(302);
    }

    public function test_store(): void
    {
        $brand = Brand::factory()->make();
        $response = $this->post('api/admin/brands',[
            'name' => $brand->name,
            'en_name' => $brand->en_name,
            'icon' => UploadedFile::fake()->image('icon.png'),
        ]);
        $brand = Brand::latest()->first();
        //
        $this->assertNotNull($brand->icon);
        $response->assertOk();
    }
}
