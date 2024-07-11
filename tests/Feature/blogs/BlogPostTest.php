<?php

namespace Tests\Feature\blogs;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Modules\blogs\App\Models\BlogPost;
use Modules\blogs\App\Models\BlogTag;

class BlogPostTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $data = BlogPost::factory()->make()->toArray();
        $data['image'] = UploadedFile::fake()->image('icon.png');
        $tags = BlogTag::limit(3)->pluck('id')->toArray();
        $data['tags'] = implode(',',$tags);
        $response = $this->actingAs($this->user)->post('api/admin/blog/posts', $data);
        $post = BlogPost::latest()->first();
        //
        $this->assertNotNull($post->image);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $post = BlogPost::inRandomOrder()->first();
        $data = BlogPost::factory()->make()->toArray();
        $data['image'] = UploadedFile::fake()->image('icon.png');
        $response = $this->actingAs($this->user)->put('api/admin/blog/posts/' . $post->id, $data);
        //
        $this->assertDatabaseHas('blog__posts', [
            'id' => $post->id,
            'title' => $data['title'],
        ]);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $post = BlogPost::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->get('api/admin/blog/posts/' . $post->id);
        $body = $response->json();
        //
        $this->assertEquals($post->id, $body['id']);
        $this->assertGreaterThan(0,$body['tags']);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/blog/posts');
        $body = $response->json();
        //
        $this->assertArrayHasKey('posts', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/blog/posts?trashed=true&title=app');
        $body = $response->json();
        $count = BlogPost::onlyTrashed()->where('title', 'like', '%app%')->count();
        //
        $this->assertEquals($body['posts']['total'], $count);
        $this->assertArrayHasKey('posts', $body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $post = BlogPost::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->delete('api/admin/blog/posts/' . $post->id);
        $this->assertDatabaseMissing('blog__posts', [
            'id' => $post->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $post = BlogPost::onlyTrashed()->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->post('api/admin/blog/posts/' . $post->id . '/restore');
        $this->assertDatabaseHas('blog__posts', [
            'id' => $post->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
    
    public function test_posts(): void
    {
        $response = $this->get('api/blog/posts');
        $body = $response->json();
        $this->assertGreaterThan(0, sizeof($body));
        $response->assertOk();
    }
}
