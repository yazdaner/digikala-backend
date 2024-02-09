<?php

namespace Tests\Feature\page;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\pages\App\Models\Page;

class PageTest extends TestCase
{
    public function test_create(): void
    {
        $page = Page::factory()->make();
        $response = $this->post('api/admin/pages', [
            'title' => $page->title,
            'en_title' => $page->en_title,
            'description' => $page->description,
            'content' => $page->content,
        ]);
        $page = Page::latest()->first();
        //
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->get('api/admin/pages');
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('pages', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->get('api/admin/pages?trashed=true&title=app');
        $body = json_decode($response->getContent(), true);
        $count = Page::onlyTrashed()->where('title', 'like', '%app%')->count();
        //
        $this->assertEquals($body['pages']['total'], $count);
        $this->assertArrayHasKey('pages', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $page = Page::factory()->create([
            'slug' => 'testSlug'
        ]);
        $response = $this->get('api/admin/pages/' . $page->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($page->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $data = Page::factory()->make();
        $page = Page::factory()->create([
            'slug' => 'testSlug'
        ]);
        $response = $this->put('api/admin/pages/' . $page->id, [
            'title' => $data->title,
            'en_title' => $data->en_title,
            'description' => $data->description,
            'content' => $data->content,
        ]);
        //
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => $data->title,
            'en_title' => $data->en_title,
            'description' => $data->description,
            'content' => $data->content,
        ]);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $page = Page::factory()->create([
            'slug' => 'testSlug'
        ]);
        $response = $this->delete('api/admin/pages/' . $page->id);
        $this->assertDatabaseMissing('pages', [
            'id' => $page->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $page = Page::factory()->create([
            'slug' => 'testSlug',
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->post('api/admin/pages/' . $page->id . '/restore');
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
}
