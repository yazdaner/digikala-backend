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

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/promotions');
        $body = $response->json();
        //
        $this->assertArrayHasKey('promotions', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/promotions?name=app');
        $body = $response->json();
        $count = Promotion::where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['promotions']['total'], $count);
        $this->assertArrayHasKey('promotions', $body);
        $response->assertOk();
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

    public function test_update()
    {
        $jdf = new Jdf();
        $promotion = Promotion::inRandomOrder()->first();
        $data = Promotion::factory()->make()->toArray();
        $timestamp1 = strtotime('today');
        $timestamp2 = strtotime('+4day');
        $data['start_time'] = $jdf->jdate('Y/n/d', $timestamp1);
        $data['end_time'] = $jdf->jdate('Y/n/d', $timestamp2);
        $response = $this->actingAs($this->user)->put('api/admin/promotions/' . $promotion->id, $data);
        //
        $this->assertDatabaseHas('promotions', [
            'id' => $promotion->id,
            'name' => $data['name'],
        ]);
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_destroy(): void
    {
        $promotion = Promotion::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->delete('api/admin/promotions/' . $promotion->id);
        $this->assertDatabaseMissing('promotions', [
            'id' => $promotion->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $promotion = Promotion::onlyTrashed()->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->post('api/admin/promotions/' . $promotion->id . '/restore');
        $this->assertDatabaseHas('promotions', [
            'id' => $promotion->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_info(): void
    {
        $promotion = Promotion::first();
        $response = $this->actingAs($this->user)->get('api/admin/promotions/' . $promotion->id . '/info');
        // \Log::info($response->json());
        $this->assertGreaterThan(0, $response->json()['variations']);
        $response->assertOk();
    }

    public function test_best_products(): void
    {
        $response = $this->actingAs($this->user)->get('api/promotion/best-products?type=amazing');
        $this->assertGreaterThan(0, $response->json()['variations']);
        $response->assertOk();
    }
}
