<?php

namespace Tests\Feature\categories;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\categories\App\Models\Category;

class CategoryTest extends TestCase
{

    public function test_create(): void
    {
        $category = Category::factory()->make();
        $response = $this->post('api/admin/categories', [
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

    public function test_show(): void
    {
        $category = Category::factory()->create([
            'slug' => 'slugTest'
        ]);
        $response = $this->get('api/admin/categories/' . $category->id);
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
        $response = $this->put('api/admin/categories/' . $category->id, [
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
        $response = $this->get('api/admin/categories');
        $body = json_decode($response->getContent(),true);
        //
        $this->assertArrayHasKey('categories',$body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->get('api/admin/categories?trashed=true&name=app');
        $body = json_decode($response->getContent(),true);
        $count = Category::onlyTrashed()->where('name','like','%app%')->count();
        //
        $this->assertEquals($body['categories']['total'],$count);
        $this->assertArrayHasKey('categories',$body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $category = Category::factory()->create([
            'slug' => 'slugTest'
        ]);
        $response = $this->delete('api/admin/categories/'.$category->id);
        $this->assertDatabaseMissing('categories',[
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
        $response = $this->post('api/admin/categories/'.$category->id.'/restore');
        $this->assertDatabaseHas('categories',[
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/categories/list');
        $body = json_decode($response->getContent(),true);
        $categories = Category::get();
        $this->assertEquals(sizeof($categories),sizeof($body));
        $response->assertOk();
    }
}
