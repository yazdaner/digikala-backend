<?php

namespace Tests\Feature\sellers;

use Tests\TestCase;
use Modules\sellers\App\Models\Seller;
use Modules\products\App\Models\Product;

class SellerProductsTest extends TestCase
{
    protected Seller $seller;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::first();
    }

    public function test_create(): void
    {
        $gallery = [
            ['path' => 'gallery/test1.png'],
            ['path' => 'gallery/test2.png'],
        ];
        $product = Product::factory()->make();
        $response = $this->actingAs($this->seller,'seller')->post('api/admin/products', [
            'title' => $product->title,
            'en_title' => $product->en_title,
            'description' => $product->description,
            'content' => $product->content,
            'status' => 1,
            'category_id' => 1,
            'weight' => fake()->numberBetween(100, 999),
            'barcode' => fake()->ean13(),
            'gallery' => $gallery,
            'product_dimensions' => 'medium',
            'keywords' => 'tag1,tag2'
        ]);
        $latest = Product::latest('id')->first();
        //
        $this->assertNotNull($latest->title);
        $response->assertOk();
    }
}
