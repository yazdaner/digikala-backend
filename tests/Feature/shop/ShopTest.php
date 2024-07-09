<?php

namespace Tests\Feature\sliders;

use Modules\products\App\Models\ProductCategory;
use Tests\TestCase;

class ShopTest extends TestCase
{
    public function test_product_info(): void
    {
        $product = runEvent('product:query',function ($query){
            return $query->whereHas('variation')->first();
        },true);
        $response = $this->get("/api/product/yzd-$product->id/$product->slug");
        $body = $response->json();
        $this->assertEquals($body['id'],$product->id);
        $this->assertGreaterThan(0,sizeof($body['variations']));
        $response->assertOk();
    }

    public function test_product_categories(): void
    {
        $product = ProductCategory::select('product_id')->first();
        $response = $this->get("/api/product/$product->product_id/categories");
        $body = $response->json();
        $this->assertGreaterThan(0,sizeof($body));
        $response->assertOk();
    }

}
