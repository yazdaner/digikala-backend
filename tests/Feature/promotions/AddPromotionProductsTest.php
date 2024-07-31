<?php

namespace Tests\Feature\promotions;

use Modules\promotions\App\Models\Promotion;
use Tests\TestCase;
use Modules\users\App\Models\User;

class AddPromotionProductsTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_products(): void
    {
        $promotion = Promotion::inRandomOrder()->first();
        $variations = runEvent('variation:query', function ($query) {
            return $query->where('product_count', '>', 0)
                ->limit(10)
                ->get();
        }, true);
        $products = [];
        foreach ($variations as $variation) {
            $products[] = [
                'variation_id' => $variation->id,
                'original_price' => $variation->price1,
                'original_count' => $variation->product_count,
                'count' => 1,
                'percent' => $promotion->min_discount,
            ];
        }

        // 

        $response = $this->actingAs($this->user)->post('api/admin/promotion/add-products', [
            'promotion_id' => $promotion->id,
            'products' => $products,
        ]);

        // 

        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
