<?php

namespace Tests\Feature\faq;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Modules\brands\App\Models\Brand;
use Modules\faq\App\Models\FaqCategories;

class FaqCategoriesTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/faq/categories', [
            'name' => fake()->text(10),
            'icon' => UploadedFile::fake()->image('icon.png'),
        ]);
        $faqCategory = FaqCategories::latest()->first();
        $this->assertNotNull($faqCategory->icon);
        $response->assertOk();
    }

    // public function test_show(): void
    // {
    //     $faqCategory = FaqCategories::first();
    //     $response = $this->actingAs($this->user)->get("api/faq/category/$faqCategory->id");
    //     $body = $response->json();
    //     //
    //     $this->assertEquals($brand->id, $body->id);
    //     $response->assertOk();
    // }

    // public function test_index(): void
    // {
    //     $response = $this->actingAs($this->user)->get('api/admin/brands');
    //     $body = $response->json();
    //     //
    //     $this->assertArrayHasKey('brands', $body);
    //     $response->assertOk();
    // }

    // public function test_index_search(): void
    // {
    //     $response = $this->actingAs($this->user)->get('api/admin/brands?trashed=true&name=app');
    //     $body = $response->json();
    //     $count = Brand::onlyTrashed()->where('name', 'like', '%app%')->count();
    //     //
    //     $this->assertEquals($body['brands']['total'], $count);
    //     $this->assertArrayHasKey('brands', $body);
    //     $response->assertOk();
    // }


    // public function test_update(): void
    // {
    //     $name = Str::random(10);
    //     $en_name = Str::random(10);
    //     $brand = Brand::factory()->create();
    //     $response = $this->actingAs($this->user)->put('api/admin/brands/' . $brand->id, [
    //         'name' => $name,
    //         'en_name' => $en_name,
    //     ]);
    //     //
    //     $this->assertDatabaseHas('products__brands', [
    //         'id' => $brand->id,
    //         'name' => $name,
    //         'en_name' => $en_name,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_destroy(): void
    // {
    //     $brand = Brand::factory()->create();
    //     $response = $this->actingAs($this->user)->delete('api/admin/brands/' . $brand->id);
    //     $this->assertDatabaseMissing('products__brands', [
    //         'id' => $brand->id,
    //         'deleted_at' => null,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_restore(): void
    // {
    //     $brand = Brand::factory()->create([
    //         'deleted_at' => Carbon::now()
    //     ]);
    //     $response = $this->actingAs($this->user)->post('api/admin/brands/' . $brand->id . '/restore');
    //     $this->assertDatabaseHas('products__brands', [
    //         'id' => $brand->id,
    //         'deleted_at' => null,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_all(): void
    // {
    //     $response = $this->get('api/brands/all');
    //     $body = $response->json();
    //     $brands = Brand::get();
    //     $this->assertEquals(sizeof($brands), sizeof($body));
    //     $response->assertOk();
    // }
}
