<?php

namespace Tests\Feature\categories;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\categories\App\Models\Category;

class CategoryTest extends TestCase
{

    public function test_create(): void
    {
        $category = Category::factory()->make();
        $response = $this->post('api/admin/categories', [
            'name' => $category->name,
            'link' => $category->link,
            'phone_number' => $category->phone_number,
        ]);
        //
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(10);
        $link = fake()->url();
        $phone_number = fake()->phoneNumber();
        $category = Category::factory()->create();
        $response = $this->put('api/admin/categories/' . $category->id, [
            'name' => $name,
            'link' => $link,
            'phone_number' => $phone_number,
        ]);
        //
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $name,
            'link' => $link,
            'phone_number' => $phone_number,
        ]);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $category = Category::factory()->create();
        $response = $this->get('api/admin/categories/' . $category->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($category->id, $body->id);
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
        $category = Category::factory()->create();
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
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->post('api/admin/categories/'.$category->id.'/restore');
        $this->assertDatabaseHas('categories',[
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
}
