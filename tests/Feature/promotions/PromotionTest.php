<?php

namespace Tests\Feature\promotions;

use Modules\core\Lib\Jdf;
use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\promotions\App\Models\Promotion;

class PromotionTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create()
    {
        $jdf = new Jdf();
        $data = Promotion::factory()->make();
        $timestamp1 = strtotime('today');
        $timestamp2 = strtotime('+4day');
        $response = $this->actingAs($this->user)->post('api/admin/promotions', [
            'name' => $data->name,
            'type' => $data->type,
            'min_discount' => $data->min_discount,
            'min_products' => $data->min_products,
            'category_id' => $data->category_id,
            'status' => $data->status,
            'start_time' => $jdf->jdate('Y/n/d', $timestamp1),
            'end_time' => $jdf->jdate('Y/n/d', $timestamp2),
        ]);
        //
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
