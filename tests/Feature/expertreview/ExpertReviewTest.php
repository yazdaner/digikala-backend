<?php

namespace Tests\Feature\expertreview;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\expertreview\App\Models\ExpertReview;

class ExpertReviewTest extends TestCase
{
    public function test_create(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $review = ExpertReview::factory()->make()->toArray();
        $response = $this->post("api/admin/products/{$product->id}/expert-review/store",$review);
        //
        $response->assertOk();
    }

    public function test_index(): void
    {
        $product = runEvent('product:query', function ($query) {
            return $query->first();
        }, true);

        $response = $this->get("api/admin/products/{$product->id}/expert-review");
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('reviews', $body);
        $response->assertOk();
    }

    // public function test_index_search(): void
    // {
    //     $response = $this->get('api/admin/expertreview?trashed=true&title=app');
    //     $body = json_decode($response->getContent(), true);
    //     $count = ExpertReview::onlyTrashed()->where('title', 'like', '%app%')->count();
    //     //
    //     $this->assertEquals($body['expertreview']['total'], $count);
    //     $this->assertArrayHasKey('expertreview', $body);
    //     $response->assertOk();
    // }

    public function test_show(): void
    {
        $review = ExpertReview::first();
        $response = $this->get("api/admin/products/expert-review/{$review->id}/show");
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($review->id, $body->id);
        $response->assertOk();
    }

    // public function test_update(): void
    // {
    //     $review = ExpertReview::first();
    //     $response = $this->put("products/expert-review/{$review->id}/update", [
    //         'title' => $data->title,
    //         'en_title' => $data->en_title,
    //         'description' => $data->description,
    //         'content' => $data->content,
    //     ]);
    //     //
    //     $this->assertDatabaseHas('expertreview', [
    //         'id' => $review->id,
    //         'title' => $data->title,
    //         'en_title' => $data->en_title,
    //         'description' => $data->description,
    //         'content' => $data->content,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_destroy(): void
    // {
    //     $review = ExpertReview::factory()->create([
    //         'slug' => 'testSlug'
    //     ]);
    //     $response = $this->delete('api/admin/expertreview/' . $review->id);
    //     $this->assertDatabaseMissing('expertreview', [
    //         'id' => $review->id,
    //         'deleted_at' => null,
    //     ]);
    //     $response->assertOk();
    // }

    // public function test_restore(): void
    // {
    //     $review = ExpertReview::factory()->create([
    //         'slug' => 'testSlug',
    //         'deleted_at' => Carbon::now()
    //     ]);
    //     $response = $this->post('api/admin/expertreview/' . $review->id . '/restore');
    //     $this->assertDatabaseHas('expertreview', [
    //         'id' => $review->id,
    //         'deleted_at' => null,
    //     ]);
    //     $response->assertOk();
    // }
}
