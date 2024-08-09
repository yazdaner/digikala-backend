<?php

namespace Tests\Feature\variations;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\colors\App\Models\Color;
use Modules\variations\App\Models\CategoryVariation;
use Modules\warranties\App\Models\Warranty;

class CategoryVariationTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $category = runEvent('category:query', function ($query) {
            return $query->first();
        }, true);
        $response = $this->actingAs($this->user)->post("api/admin/category/{$category->id}/variation", [
            'item1' => Color::class,
            'item2' => Warranty::class
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $category = runEvent('category:query', function ($query) {
            return $query->first();
        }, true);
        $response = $this->actingAs($this->user)->get("api/admin/category/{$category->id}/variation");
        $body = json_decode($response->getContent());
        $this->assertObjectHasProperty('category_id', $body);
        $response->assertOk();
    }

    public function test_variation_items(): void
    {
        $categoryItems = CategoryVariation::first();
        $response = $this->actingAs($this->user)
            ->post("api/admin/category/{$categoryItems->category_id}/variation/items");
        $response->assertOk();
    }
}
