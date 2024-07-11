<?php

namespace Tests\Feature\blogs;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\blogs\App\Models\BlogCategory;

class BlogCategoryTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $data = BlogCategory::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post('api/admin/blog/categories', $data);
        //
        $response->assertOk();
    }

    public function test_show(): void
    {
        $category = BlogCategory::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->get('api/admin/blog/categories/' . $category->id);
        $body = $response->json();
        //
        $this->assertEquals($category->id, $body['id']);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $category = BlogCategory::inRandomOrder()->first();
        $data = BlogCategory::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->put('api/admin/blog/categories/' . $category->id, $data);
        //
        $this->assertDatabaseHas('blog__categories', [
            'id' => $category->id,
            'name' => $data['name'],
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/blog/categories');
        $body = $response->json();
        //
        $this->assertArrayHasKey('categories', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/blog/categories?trashed=true&name=app');
        $body = $response->json();
        $count = BlogCategory::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['categories']['total'], $count);
        $this->assertArrayHasKey('categories', $body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $category = BlogCategory::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->delete('api/admin/blog/categories/' . $category->id);
        $this->assertDatabaseMissing('blog__categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $category = BlogCategory::onlyTrashed()->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->post('api/admin/blog/categories/' . $category->id . '/restore');
        $this->assertDatabaseHas('blog__categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/blog/categories/all');
        $body = $response->json();
        $categories = BlogCategory::get();
        $this->assertEquals(sizeof($categories), sizeof($body));
        $response->assertOk();
    }
}
