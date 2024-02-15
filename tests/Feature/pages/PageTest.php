<?php

namespace Tests\Feature\page;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\pages\App\Models\Page;

class PageTest extends TestCase
{
    public function test_create(): void
    {
        $admin = getAdminForTest();
        $page = Page::factory()->make();
        $response = $this->actingAs($admin)->post('api/admin/pages', [
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
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/pages');
        $body = json_decode($response->getContent(), true);
        //
        $this->assertArrayHasKey('pages', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/pages?trashed=true&title=app');
        $body = json_decode($response->getContent(), true);
        $count = Page::onlyTrashed()->where('title', 'like', '%app%')->count();
        //
        $this->assertEquals($body['pages']['total'], $count);
        $this->assertArrayHasKey('pages', $body);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $admin = getAdminForTest();
        $page = Page::factory()->create([
            'slug' => 'testSlug'
        ]);
        $response = $this->actingAs($admin)->get('api/admin/pages/' . $page->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($page->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $data = Page::factory()->make();
        $page = Page::factory()->create([
            'slug' => 'testSlug'
        ]);
        $response = $this->actingAs($admin)->put('api/admin/pages/' . $page->id, [
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
        $admin = getAdminForTest();
        $page = Page::factory()->create([
            'slug' => 'testSlug'
        ]);
        $response = $this->actingAs($admin)->delete('api/admin/pages/' . $page->id);
        $this->assertDatabaseMissing('pages', [
            'id' => $page->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $page = Page::factory()->create([
            'slug' => 'testSlug',
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($admin)->post('api/admin/pages/' . $page->id . '/restore');
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
}
