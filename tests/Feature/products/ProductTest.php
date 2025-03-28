<?php

namespace Tests\Feature\products;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\users\App\Models\User;
use Modules\products\App\Models\Product;
use Modules\sellers\App\Models\Seller;

class ProductTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $gallery = [
            ['path' => 'gallery/test1.png'],
            ['path' => 'gallery/test2.png'],
        ];
        $product = Product::factory()->make();
        $response = $this->actingAs($this->user)->post('api/admin/products', [
            'title' => $product->title,
            'en_title' => $product->en_title,
            'description' => $product->description,
            'content' => $product->content,
            'status' => 1,
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
            'weight' => fake()->numberBetween(100, 999),
            'barcode' => fake()->ean13(),
            'gallery' => $gallery,
            'product_dimensions' => 'medium',
            'keywords' => 'tag1,tag2',
            'user_id' => 1,
            'user_type' => Seller::class
        ]);
        $latest = Product::latest('id')->first();
        //
        $this->assertNotNull($latest->title);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/products');
        $body = $response->json();
        //
        $this->assertArrayHasKey('products', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/products?title=app');
        $body = $response->json();
        $count = Product::where('title', 'like', '%app%')->count();
        //
        $this->assertEquals($body['products']['total'], $count);
        $this->assertArrayHasKey('products', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $product = Product::factory()->create([
            'slug' => 'test'
        ]);
        $response = $this->actingAs($this->user)->get('api/admin/products/' . $product->id);
         //
        $this->assertEquals($product->id, $response->json()['id']);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $product = Product::factory()->create([
            'slug' => 'test'
        ]);
        $response = $this->actingAs($this->user)->delete('api/admin/products/' . $product->id);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $product = Product::factory()->create([
            'slug' => 'test',
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($this->user)->post('api/admin/products/' . $product->id . '/restore');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $title = Str::random(10);
        $en_title = Str::random(10);
        $product = Product::factory()->create([
            'slug' => 'test'
        ]);
        $response = $this->actingAs($this->user)->put('api/admin/products/' . $product->id, [
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
