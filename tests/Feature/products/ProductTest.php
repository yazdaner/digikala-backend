<?php

namespace Tests\Feature\products;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\products\App\Models\Product;

class ProductTest extends TestCase
{
    public function test_create(): void
    {
        $admin = getAdminForTest();
        $gallery = [
            ['path' => 'gallery/test1.png'],
            ['path' => 'gallery/test2.png'],
        ];
        $product = Product::factory()->make();
        $response = $this->actingAs($admin)->post('api/admin/products', [
            'title' => $product->title,
            'en_title' => $product->en_title,
            'description' => $product->description,
            'content' => $product->content,
            'status' => 0,
            'category_id' => 7,
            'weight' => fake()->numberBetween(100, 999),
            'barcode' => fake()->ean13(),
            'gallery' => $gallery,
        ]);
        $latest = Product::latest('id')->first();
        //
        $this->assertNotNull($latest->title);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/products');
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('products', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/products?title=app');
        $body = json_decode($response->getContent(), true);
        $count = Product::where('title', 'like', '%app%')->count();
        //
        $this->assertEquals($body['products']['total'], $count);
        $this->assertArrayHasKey('products', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $admin = getAdminForTest();
        $product = Product::factory()->create([
            'slug' => 'test'
        ]);
        $response = $this->actingAs($admin)->get('api/admin/products/' . $product->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($product->id, $body->id);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $admin = getAdminForTest();
        $product = Product::factory()->create([
            'slug' => 'test'
        ]);
        $response = $this->actingAs($admin)->delete('api/admin/products/' . $product->id);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $product = Product::factory()->create([
            'slug' => 'test',
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($admin)->post('api/admin/products/' . $product->id . '/restore');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $title = Str::random(10);
        $en_title = Str::random(10);
        $product = Product::factory()->create([
            'slug' => 'test'
        ]);
        $response = $this->actingAs($admin)->put('api/admin/products/' . $product->id, [
            'title' => $title,
            'en_title' => $en_title,
        ]);
        //
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => $title,
            'en_title' => $en_title,
        ]);
        $response->assertOk();
    }
}
