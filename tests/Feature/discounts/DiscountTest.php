<?php

namespace Tests\Feature\discounts;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\users\App\Models\User;
use Modules\discounts\App\Models\Discount;

class DiscountTest extends TestCase
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

    // public function test_index(): void
    // {
    //     $response = $this->actingAs($this->user)->get('api/admin/discounts');
    //     $body = $response->json();
    //     //
    //     $this->assertArrayHasKey('discounts', $body);
    //     $response->assertOk();
    // }

    // public function test_index_search(): void
    // {
    //     $response = $this->actingAs($this->user)->get('api/admin/discounts?trashed=true&name=app');
    //     $body = $response->json();
    //     $count = Discount::onlyTrashed()->where('name', 'like', '%app%')->count();
    //     //
    //     $this->assertEquals($body['discounts']['total'], $count);
    //     $this->assertArrayHasKey('discounts', $body);
    //     $response->assertOk();
    // }
    // public function test_show(): void
    // {
    //     $discount = Discount::factory()->create();
    //     $response = $this->actingAs($this->user)->get('api/admin/discounts/' . $discount->id);
    //     $body = json_decode($response->getContent());
    //     //
    //     $this->assertEquals($discount->id, $body->id);
    //     $response->assertOk();
    // }

    // public function test_update(): void
    // {
    //     $name = Str::random(10);
    //     $discount = Discount::factory()->create();
    //     $response = $this->actingAs($this->user)->put('api/admin/discounts/' . $discount->id, [
    //         'name' => $name,
    //     ]);
    //     //
    //     $this->assertDatabaseHas('products__discounts', [
    //         'id' => $discount->id,
    //         'name' => $name,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_destroy(): void
    // {
    //     $discount = Discount::factory()->create();
    //     $response = $this->actingAs($this->user)->delete('api/admin/discounts/' . $discount->id);
    //     $this->assertDatabaseMissing('products__discounts', [
    //         'id' => $discount->id,
    //         'deleted_at' => null,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_restore(): void
    // {
    //     $discount = Discount::factory()->create([
    //         'deleted_at' => Carbon::now()
    //     ]);
    //     $response = $this->actingAs($this->user)->post('api/admin/discounts/' . $discount->id . '/restore');
    //     $this->assertDatabaseHas('products__discounts', [
    //         'id' => $discount->id,
    //         'deleted_at' => null,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_all(): void
    // {
    //     $response = $this->get('api/discounts/all');
    //     $body = $response->json();
    //     $discounts = Discount::get();
    //     $this->assertEquals(sizeof($discounts), sizeof($body));
    //     $response->assertOk();
    // }
}
