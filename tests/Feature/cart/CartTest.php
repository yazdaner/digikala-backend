<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\cart\App\Models\Cart;
use Modules\variations\App\Models\Variation;

class CartTest extends TestCase
{
    public function  test_add_product_to_cart(): void
    {
        $variation = Variation::factory()->create();
        $response = $this->post('api/cart/add-product', [
            'count' => 1,
            'variationId' => $variation->id,
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals($variation->id, $body['variation']['id']);
        $this->assertEquals('ok', $body['status']);
        $response->assertOk();
    }

    public function test_add_product_to_cart_table(): void
    {
        $user = getUserForTest();
        $variation = Variation::factory()->create();
        $response = $this->actingAs($user)->post('api/cart/add-product', [
            'count' => 1,
            'variationId' => $variation->id,
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals($variation->id, $body['variation']['id']);
        $this->assertEquals('ok', $body['status']);
        $this->assertDatabaseHas('carts', [
            'variation_id' => $body['variation']['id'],
            'user_id' => $user->id,
            'count' => 1,
        ]);
        $response->assertOk();
    }

    public function test_remove_product_from_cart_table(): void
    {
        $user = getUserForTest();
        // $variation = Variation::orderBy('id','DESC')->first();
        $variationId = Cart::where([
            'user_id' => $user->id
        ])->first()->variation_id;
        $response = $this->actingAs($user)->post('api/cart/remove-product', [
            'variationId' => $variationId,
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals('ok', $body['status']);
        $this->assertDatabaseMissing('carts', [
            'variation_id' => $variationId,
            'user_id' => $user->id,
        ]);
        $response->assertOk();
    }
}
