<?php

namespace Tests\Feature\expertreview;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\expertreview\App\Models\ExpertReview;

class ExpertReviewTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }
    
    public function test_create(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $review = ExpertReview::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post("api/admin/products/{$product->id}/expert-review/store",$review);
        //
        $response->assertOk();
    }

    public function test_index(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $response = $this->actingAs($this->user)->get("api/admin/products/{$product->id}/expert-review");
        $body = $response->json();
        //
        $this->assertArrayHasKey('reviews', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $review = ExpertReview::first();
        $response = $this->actingAs($this->user)->get("api/admin/products/expert-review/{$review->id}/show");
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($review->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $data = ExpertReview::factory()->make()->toArray();
        $review = ExpertReview::first();
        $response = $this->actingAs($this->user)->put("api/admin/products/expert-review/{$review->id}/update",$data);
        $data['id'] = $review->id;
        //
        $this->assertDatabaseHas('products__expert_review',$data);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $review = ExpertReview::factory()->create([
            'product_id' => $product->id
        ]);
        $response = $this->actingAs($this->user)->delete("api/admin/products/expert-review/{$review->id}/destroy");
        $this->assertDatabaseMissing('products__expert_review', [
            'id' => $review->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $review = ExpertReview::factory()->create([
            'product_id' => $product->id,
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($this->user)->post("api/admin/products/expert-review/{$review->id}/restore");
        $this->assertDatabaseHas('products__expert_review', [
            'id' => $review->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $response = $this->get("api/products/{$product->id}/expert-review/all");
        $body = $response->json();
        $count = ExpertReview::where('product_id', $product->id)->count();
        //
        $this->assertEquals(sizeof($body), $count);
        $response->assertOk();
    }
}
