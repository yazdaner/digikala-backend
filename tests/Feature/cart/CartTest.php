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

    public function test_return_cart_info_for_guest(): void
    {
        $cart = [];
        $variations = runEvent('variation:query', function ($query) {
            return $query->where('status', 1)
                ->where('product_count', '>', 0)
                ->select('id')
                ->limit(3)->get();
        }, true);
        foreach ($variations as $variation) {
            $cart[$variation->id] = 1;
        }
        $response = $this->post('api/cart', [
            'cart' => $cart
        ]);
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('current', $body);
        $this->assertEquals(sizeof($cart), sizeof($body['current']['products']));
        $response->assertOk();
    }

    public function test_return_cart_info_for_user(): void
    {
        $user = getUserForTest();
        Cart::where('user_id', $user->id)->delete();
        $variations = runEvent('variation:query', function ($query) {
            return $query->where('status', 1)
                ->where('product_count', '>', 0)
                ->select(['id', 'price2'])
                ->limit(3)->get();
        }, true);
        foreach ($variations as $variation) {
            Cart::create([
                'variation_id' => $variation->id,
                'count' => 1,
                'user_id' => $user->id,
                'price' => $variation->price2,
                'type' => 1
            ]);
        }
        $response = $this->actingAs($user)->post('api/cart');
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('current', $body);
        $this->assertEquals(sizeof($variations), sizeof($body['current']['products']));
        $response->assertOk();
    }

    public function test_cart_after_change_price(): void
    {
        $user = getUserForTest();
        Cart::where('user_id', $user->id)->delete();
        $variations = runEvent('variation:query', function ($query) {
            return $query->where('status', 1)
                ->where('product_count', '>', 0)
                ->select(['id', 'price2'])
                ->limit(3)->get();
        }, true);
        foreach ($variations as $variation) {
            Cart::create([
                'variation_id' => $variation->id,
                'count' => 1,
                'user_id' => $user->id,
                'price' => $variation->price2,
                'type' => 1
            ]);
        }
        foreach ($variations as $variation) {
            $variation->price2 = ($variation->price2 + 10000);
            $variation->update();
        }
        $response = $this->actingAs($user)->post('api/cart?check-change=true');
        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('current', $body);
        $this->assertEquals(sizeof($variations), sizeof($body['current']['products']));
        $this->assertArrayHasKey('old_price', $body['current']['products'][0]);
        $response->assertOk();
    }

    public function test_add_product_to_next_cart(): void
    {
        $user = getUserForTest();
        $data = Cart::where([
            'user_id' => $user->id,
            'type' => 1
        ])->first();
        $response = $this->actingAs($user)->post('api/cart/add-next-card', [
            'variationId' => $data->variation_id
        ]);
        $this->assertEquals(
            null,
            Cart::where([
                'user_id' => $user->id,
                'type' => 1,
                'variation_id' => $data->variation_id
            ])->first()
        );
        $response->assertOk();
    }

    public function test_add_product_to_current_cart(): void
    {
        $user = getUserForTest();
        $data = Cart::where([
            'user_id' => $user->id,
            'type' => 2
        ])->first();
        $response = $this->actingAs($user)->post('api/cart/add-current-card', [
            'variationId' => $data->variation_id
        ]);
        $this->assertEquals(
            null,
            Cart::where([
                'user_id' => $user->id,
                'type' => 2,
                'variation_id' => $data->variation_id
            ])->first()
        );
        $response->assertOk();
    }

    public function test_save_to_carts_table(): void
    {
        $user = getUserForTest();
        $cart = [];
        Cart::where('user_id',$user->id)->delete();
        $variations = runEvent('variation:query', function ($query) {
            return $query->where('status', 1)
                ->where('product_count', '>', 0)
                ->select('id')
                ->limit(3)->get();
        }, true);
        foreach ($variations as $variation) {
            $cart[$variation->id] = 1;
        }
        $response = $this->actingAs($user)->post('api/user/card/save-database', [
            'cart' => $cart
        ]);
        $this->assertEquals(sizeof($cart),Cart::where('user_id',$user->id)->count());
        $response->assertOk();
    }
}
