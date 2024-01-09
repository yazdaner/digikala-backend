<?php

namespace Tests\Feature\brand;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\brands\App\Models\Brand;

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

    public function test_show(): void
    {
        $brand = Brand::factory()->create();
        $response = $this->get('api/admin/brands/'.$brand->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($brand->id,$body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(10);
        $en_name = Str::random(10);
        $brand = Brand::factory()->create();
        $response = $this->put('api/admin/brands/'.$brand->id,[
            'name' => $name,
            'en_name' => $en_name,
        ]);
        // 
        $this->assertDatabaseHas('products__brands',[
            'id' => $brand->id,
            'name' => $name,
            'en_name' => $en_name,
        ]);
        $response->assertOk();
    }
}
