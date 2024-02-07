<?php

namespace Tests\Feature\variations;

use Tests\TestCase;
use Modules\colors\App\Models\Color;
use Modules\warranties\App\Models\Warranty;

class CategoryVariationTest extends TestCase
{

    public function test_create(): void
    {
        $category = runEvent('category:query', function ($query) {
            return $query->first();
        }, true);

        $response = $this->post("api/admin/category/{$category->id}/variation", [
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
        $response = $this->get("api/admin/category/{$category->id}/variation");
        $body = json_decode($response->getContent());
        $this->assertObjectHasProperty('category_id', $body);
        $response->assertOk();
    }
}
