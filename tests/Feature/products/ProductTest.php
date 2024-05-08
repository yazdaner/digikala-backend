<?php

namespace Tests\Feature\products;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\users\App\Models\User;
use Modules\products\App\Models\Product;

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
            'status' => 0,
            'category_id' => 1,
            'weight' => fake()->numberBetween(100, 999),
            'barcode' => fake()->ean13(),
            'gallery' => $gallery,
            'product_dimensions' => 'medium'
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
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($product->id, $body->id);
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
