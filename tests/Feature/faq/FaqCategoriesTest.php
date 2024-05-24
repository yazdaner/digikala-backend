<?php

namespace Tests\Feature\faq;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Modules\faq\App\Models\FaqCategories;

class FaqCategoriesTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/faq/categories', [
            'name' => fake()->text(10),
            'icon' => UploadedFile::fake()->image('icon.png'),
        ]);
        $faqCategory = FaqCategories::latest()->first();
        // 
        $this->assertNotNull($faqCategory->icon);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $faqCategory = FaqCategories::first();
        $response = $this->actingAs($this->user)->get("api/admin/faq/categories/$faqCategory->id");
        $body = $response->json();
        //
        $this->assertEquals($faqCategory->id, $body['id']);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(5);
        $faqCategory = FaqCategories::first();
        $response = $this->actingAs($this->user)->put("api/admin/faq/categories/$faqCategory->id", [
            'name' => $name,
            'icon' => null,
        ]);
        //
        $this->assertDatabaseHas('faq__categories', [
            'id' => $faqCategory->id,
            'name' => $name,
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/faq/categories');
        $body = $response->json();
        //
        $this->assertArrayHasKey('faqCategories', $body);
        $this->assertGreaterThan(0, $body['faqCategories']['total']);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/faq/categories?trashed=true&name=app');
        $body = $response->json();
        $count = FaqCategories::onlyTrashed()->where('name', 'like', '%app%')->count();
        //
        $this->assertEquals($body['faqCategories']['total'], $count);
        $this->assertArrayHasKey('faqCategories', $body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $faqCategory = FaqCategories::first();
        $response = $this->actingAs($this->user)->delete("api/admin/faq/categories/$faqCategory->id");
        $this->assertDatabaseMissing('faq__categories', [
            'id' => $faqCategory->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $faqCategory = FaqCategories::onlyTrashed()->first();
        $response = $this->actingAs($this->user)->post("api/admin/faq/categories/{$faqCategory->id}/restore");
        $this->assertDatabaseHas('faq__categories', [
            'id' => $faqCategory->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/faq/category/all');
        $body = $response->json();
        $faqCategories = FaqCategories::get();
        $this->assertEquals(sizeof($faqCategories), sizeof($body));
        $response->assertOk();
    }
}