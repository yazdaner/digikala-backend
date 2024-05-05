<?php

namespace Tests\Feature\variations;

use Modules\colors\App\Models\Color;
use Modules\variations\App\Models\Variation;
use Modules\warranties\App\Models\Warranty;
use Tests\TestCase;

class ProductVariationTest extends TestCase
{

    public function test_create(): void
    {
        $admin = getAdminForTest();
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);
        $response = $this->actingAs($admin)->post("api/admin/products/{$product->id}/variations/store", [
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

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $variation = Variation::first();
        $price1 = rand(99, 999);
        $price2 = rand(99, 999);
        $product_count = rand(0, 10);
        $max_product_cart = rand(0, 2);
        $preparation_time = rand(0, 2);
        $response = $this->actingAs($admin)->put("api/admin/products/variations/{$variation->id}/update", [
            'price1' => $price1,
            'price2' => $price2,
            'product_count' => $product_count,
            'max_product_cart' => $max_product_cart,
            'preparation_time' => $preparation_time
        ]);

        $this->assertDatabaseHas('products__variations', [
            'id' => $variation->id,
            'price1' => $price1,
            'price2' => $price2,
            'product_count' => $product_count,
            'max_product_cart' => $max_product_cart,
            'preparation_time' => $preparation_time
        ]);
        $response->assertOk();
    }


    public function test_destroy(): void
    {
        $admin = getAdminForTest();
        $variation = Variation::first();
        $response = $this->actingAs($admin)->delete("api/admin/products/variations/{$variation->id}/destroy");
        $this->assertDatabaseMissing('products__variations', [
            'id' => $variation->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $variation = Variation::onlyTrashed()->first();
        $response = $this->actingAs($admin)->post("api/admin/products/variations/{$variation->id}/restore");
        $this->assertDatabaseHas('products__variations', [
            'id' => $variation->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_unique_variation_rule(): void
    {
        $admin = getAdminForTest();
        $variation = Variation::first();
        $response = $this->actingAs($admin)->post("api/admin/products/{$variation->product_id}/variations/store", [
            'price1' => rand(9999, 99999),
            'price2' => rand(9999, 99999),
            'product_count' => rand(0, 100),
            'max_product_cart' => rand(0, 5),
            'preparation_time' => rand(0, 5),
            'param1_type' => $variation->param1_type,
            'param1_id' => $variation->param1_id,
            'param2_type' => $variation->param2_type,
            'param2_id' => $variation->param2_id
        ]);
        $response->assertSessionHasErrors();
        $response->assertStatus(302);
    }
}
