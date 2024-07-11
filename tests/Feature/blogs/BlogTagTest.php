<?php

namespace Tests\Feature\blogs;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\blogs\App\Models\BlogTag;

class BlogTagTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $data = BlogTag::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post('api/admin/blog/tags', $data);
        //
        $response->assertOk();
    }

    public function test_show(): void
    {
        $tag = BlogTag::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->get('api/admin/blog/tags/' . $tag->id);
        $body = $response->json();
        //
        $this->assertEquals($tag->id, $body['id']);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $tag = BlogTag::inRandomOrder()->first();
        $data = BlogTag::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->put('api/admin/blog/tags/' . $tag->id, $data);
        //
        $this->assertDatabaseHas('blog__tags', [
            'id' => $tag->id,
            'name' => $data['name'],
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/blog/tags');
        $body = $response->json();
        //
        $this->assertArrayHasKey('tags', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/blog/tags?trashed=true&name=app');
        $body = $response->json();
        $count = BlogTag::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['tags']['total'], $count);
        $this->assertArrayHasKey('tags', $body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $tag = BlogTag::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->delete('api/admin/blog/tags/' . $tag->id);
        $this->assertDatabaseMissing('blog__tags', [
            'id' => $tag->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $tag = BlogTag::onlyTrashed()->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->post('api/admin/blog/tags/' . $tag->id . '/restore');
        $this->assertDatabaseHas('blog__tags', [
            'id' => $tag->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
    
    public function test_all(): void
    {
        $response = $this->get('api/blog/tags/all');
        $body = $response->json();
        $tags = BlogTag::get();
        $this->assertEquals(sizeof($tags), sizeof($body));
        $response->assertOk();
    }
}
