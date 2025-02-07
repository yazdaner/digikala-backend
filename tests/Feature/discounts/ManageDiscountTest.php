<?php

namespace Tests\Feature\discounts;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\discounts\App\Models\Discount;

class ManageDiscountTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create_with_amount(): void
    {
        $data = Discount::factory()->make();
        $response = $this->actingAs($this->user)->post('api/admin/discounts', [
            'code' => $data->code,
            'expiration_date' => $data->expiration_date,
            'amount' => $data->amount,
            'max_amount' => $data->max_amount,
            'min_purchase' => $data->min_purchase,
            'category_id' => $data->category_id,
        ]);
        $discount = Discount::latest()->first();
        //
        $this->assertEquals($discount->code, $data->code);
        $response->assertOk();
    }

    public function test_create_with_percent(): void
    {
        $data = Discount::factory()->make();
        $response = $this->actingAs($this->user)->post('api/admin/discounts', [
            'code' => $data->code,
            'expiration_date' => $data->expiration_date,
            'percent' => $data->percent,
            'max_amount' => $data->max_amount,
            'min_purchase' => $data->min_purchase,
            'category_id' => $data->category_id,
        ]);
        $discount = Discount::latest()->first();
        //
        $this->assertEquals($discount->code, $data->code);
        $response->assertOk();
    }
}
