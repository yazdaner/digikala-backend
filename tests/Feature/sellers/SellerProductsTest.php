<?php

namespace Tests\Feature\sellers;

use Tests\TestCase;
use Modules\colors\App\Models\Color;
use Modules\sellers\App\Models\Seller;
use Modules\products\App\Models\Product;
use Modules\warranties\App\Models\Warranty;

class SellerProductsTest extends TestCase
{
    protected Seller $seller;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::inRandomOrder()->first();
    }

    public function test_create_product(): void
    {
        $gallery = [
            ['path' => 'gallery/test1.png'],
            ['path' => 'gallery/test2.png'],
        ];
        $product = Product::factory()->make();
        $response = $this->actingAs($this->seller, 'seller')->post('api/admin/products', [
            'title' => $product->title,
            'en_title' => $product->en_title,
            'description' => $product->description,
            'content' => $product->content,
            'status' => 1,
            'category_id' => $product->category_id,
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

    public function test_create_variation(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->inRandomOrder()->first();
        }, true);
        $response = $this->actingAs($this->seller, 'seller')->post("api/admin/products/{$product->id}/variations/store", [
            'price1' => rand(9999, 99999),
            'price2' => rand(9999, 99999),
            'product_count' => rand(0, 100),
            'max_product_cart' => rand(0, 5),
            'preparation_time' => rand(0, 5),
            'param1_type' => Color::class,
            'param1_id' => rand(1, 99),
            'param2_type' => Warranty::class,
            'param2_id' => rand(1, 99),
            'status' => 1
        ]);
        $response->assertOk();
    }

    public function test_return_shop_all_products(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->inRandomOrder()->first();
        }, true);
        $response = $this->actingAs($this->seller, 'seller')->get("api/seller/products/all?category_id=$product->category_id");
        $this->assertGreaterThan(0, sizeof($response->json()['data']));
        $response->assertOk();
    }

    public function test_seller_products(): void
    {
        $response = $this->actingAs($this->seller, 'seller')->get("api/seller/products");
        $this->assertGreaterThan(0, sizeof($response->json()['data']));
        $response->assertOk();
    }

    public function test_products_general_info(): void
    {
        $response = $this->actingAs($this->seller, 'seller')->get("api/seller/products/general-info");
        $this->assertGreaterThan(0,$response->json()['totalProducts']);
        $response->assertOk();
    }
}
