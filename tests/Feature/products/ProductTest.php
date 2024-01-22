<?php

namespace Tests\Feature\products;

use Tests\TestCase;
use Modules\products\App\Models\Product;

class ProductTest extends TestCase
{

    public function test_create(): void
    {
        $product = Product::factory()->make();
        $response = $this->post('api/admin/products', [
            'title' => $product->title,
            'en_title' => $product->en_title,
            'description' => $product->description,
            'content' => $product->content,
            'status' => 0,
        ]);
        $latest = Product::latest('id')->first();
        //
        $this->assertNotNull($latest->title);
        $response->assertOk();
    }

}
