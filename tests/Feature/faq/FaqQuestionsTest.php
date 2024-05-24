<?php

namespace Tests\Feature\faq;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Modules\faq\App\Models\FaqQuestions;
use Modules\faq\App\Models\FaqCategories;

class FaqQuestionsTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $data = FaqQuestions::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post('api/admin/faq/questions',$data);
        // 
        $this->assertDatabaseHas('faq__questions',$data);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $faqQuestion = FaqQuestions::first();
        $response = $this->actingAs($this->user)->get("api/admin/faq/questions/$faqQuestion->id");
        $body = $response->json();
        //
        $this->assertEquals($faqQuestion->id, $body['id']);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $data = FaqQuestions::factory()->make()->toArray();
        $faqQuestion = FaqQuestions::first();
        $response = $this->actingAs($this->user)->put("api/admin/faq/questions/$faqQuestion->id",$data);
        //
        $this->assertDatabaseHas('faq__questions',$data);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/faq/questions');
        $body = $response->json();
        //
        $this->assertArrayHasKey('faqQuestions', $body);
        $this->assertGreaterThan(0, $body['faqQuestions']['total']);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/faq/questions?trashed=true&title=app');
        $body = $response->json();
        $count = FaqQuestions::onlyTrashed()->where('title', 'like', '%app%')->count();
        //
        $this->assertEquals($body['faqQuestions']['total'], $count);
        $this->assertArrayHasKey('faqQuestions', $body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $faqQuestion = FaqQuestions::first();
        $response = $this->actingAs($this->user)->delete("api/admin/faq/questions/$faqQuestion->id");
        $this->assertDatabaseMissing('faq__questions', [
            'id' => $faqQuestion->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $faqQuestion = FaqQuestions::onlyTrashed()->first();
        $response = $this->actingAs($this->user)->post("api/admin/faq/questions/{$faqQuestion->id}/restore");
        $this->assertDatabaseHas('faq__questions', [
            'id' => $faqQuestion->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_list(): void
    {
        $response = $this->get('api/faq/questions');
        $body = $response->json();
        $faqQuestions = FaqQuestions::get();
        $this->assertEquals(sizeof($faqQuestions), sizeof($body));
        $response->assertOk();
    }

    public function test_filter_list(): void
    {
        $faqCategory = FaqCategories::select(['id'])->first();
        $response = $this->get("api/faq/questions?category_id=$faqCategory->id");
        $body = $response->json();
        $faqQuestions = FaqQuestions::where('category_id',$faqCategory->id)->get();
        // 
        $this->assertEquals(sizeof($faqQuestions), sizeof($body));
        $response->assertOk();
    }

    public function test_info(): void
    {
        $faqQuestion = FaqQuestions::first();
        $response = $this->actingAs($this->user)->get("api/faq/question/{$faqQuestion->id}/info");
        $body = $response->json();
        //
        $this->assertEquals($faqQuestion->id, $body['id']);
        $response->assertOk();
    }
}
