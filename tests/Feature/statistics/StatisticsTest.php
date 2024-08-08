<?php

namespace Tests\Feature\sliders;

use Tests\TestCase;
use Modules\users\App\Models\User;

class StatisticsTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_sale_province(): void
    {
        $response = $this->actingAs($this->user)
            ->get('api/admin/statistics/sale-province');
        // \Log::info($response->json());
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertOk();
    }

    public function test_general_sale(): void
    {
        $response = $this->actingAs($this->user)
            ->get('api/admin/statistics/general-sale');
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertOk();
    }

    public function test_general_sale_with_year(): void
    {
        $response = $this->actingAs($this->user)
            ->get('api/admin/statistics/general-sale?year=1402');
        $this->assertEquals(12, sizeof($response->json()['countData']));
        $response->assertOk();
    }

    public function test_general_sale_with_month(): void
    {
        $response = $this->actingAs($this->user)
            ->get('api/admin/statistics/general-sale?month=1');
        $this->assertEquals(31, sizeof($response->json()['countData']));
        $response->assertOk();
    }

    public function test_product_sale(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $response = $this->actingAs($this->user)
            ->get('api/admin/statistics/product-sale?product_id=' . $product->id);
        $this->assertEquals(12, sizeof($response->json()['countData']));
        $response->assertOk();
    }

    public function test_sell_by_category_brand(): void
    {
        $response = $this->actingAs($this->user)
            ->get('api/admin/statistics/sell/by-category-brand?groupBy=category_id');
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertOk();
    }
}
