<?php

namespace Tests\Feature\categories;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Modules\categories\App\Models\Category;

class CategoryTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create_parent_category(): void
    {
        $category = Category::factory()->make();
        $response = $this->actingAs($this->user)->post('api/admin/categories', [
            'name' => $category->name,
            'en_name' => $category->en_name,
            'icon' => $category->icon,
            'image' => UploadedFile::fake()->image('pic.png')
        ]);
        $latest = Category::latest('id')->first();
        //
        $this->assertNotNull($latest->icon);
        $response->assertOk();
    }

    public function test_create_child_category(): void
    {
        $category = Category::factory()->make();
        $response = $this->actingAs($this->user)->post('api/admin/categories', [
            'name' => $category->name,
            'en_name' => $category->en_name,
            'icon' => $category->icon,
            'parent_id' => $category->parent_id,
            'image' => UploadedFile::fake()->image('pic.png')
        ]);
        $latest = Category::latest('id')->first();
        //
        $this->assertNotNull($latest->icon);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $category = Category::factory()->create([
            'slug' => 'slugTest'
        ]);
        $response = $this->actingAs($this->user)->get('api/admin/categories/' . $category->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($category->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(10);
        $en_name = Str::random(10);
        $category = Category::factory()->create([
            'slug' => 'slugTest'
        ]);
        $response = $this->actingAs($this->user)->put('api/admin/categories/' . $category->id, [
            'name' => $name,
            'en_name' => $en_name,
        ]);
        //
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $name,
            'en_name' => $en_name,
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/categories');
        $body = $response->json();
        //
        $this->assertArrayHasKey('categories', $body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/categories?trashed=true&name=app');
        $body = $response->json();
        $count = Category::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['categories']['total'], $count);
        $this->assertArrayHasKey('categories', $body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $category = Category::factory()->create([
            'slug' => 'slugTest'
        ]);
        $response = $this->actingAs($this->user)->delete('api/admin/categories/' . $category->id);
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $category = Category::factory()->create([
            'slug' => 'slugTest',
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($this->user)->post('api/admin/categories/' . $category->id . '/restore');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/categories/all');
        $body = $response->json();
        $categories = Category::get();
        $this->assertEquals(sizeof($categories), sizeof($body));
        $response->assertOk();
    }
}
