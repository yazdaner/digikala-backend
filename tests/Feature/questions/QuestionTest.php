<?php

namespace Tests\Feature\questions;

use Modules\questions\App\Models\Question;
use Tests\TestCase;
use Modules\users\App\Models\User;

class QuestionTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    function test_add_question(): void
    {
        $product = runEvent('product:query',function($query){
            return $query->select('id')->first();
        },true);
        $content = fake()->sentence();
        $response = $this->actingAs($this->user)->post('api/user/question',[
            'product_id' => $product->id,
            'content' => $content
        ]);
        $this->assertDatabaseHas('questions',[
            'product_id' => $product->id,
            'user_id' => $this->user->id,
            'content' => $content
        ]);
        $response->assertOk();
    }

    function test_add_answer(): void
    {
        $product = runEvent('product:query',function($query){
            return $query->select('id')->first();
        },true);
        $question = Question::first();
        $content = fake()->sentence();
        $response = $this->actingAs($this->user)->post('api/user/question',[
            'product_id' => $product->id,
            'parent_id' => $question->id,
            'content' => $content
        ]);
        $this->assertDatabaseHas('questions',[
            'product_id' => $product->id,
            'parent_id' => $question->id,
            'user_id' => $this->user->id,
            'content' => $content
        ]);
        $response->assertOk();
    }

    function test_add_like(): void
    {
        $answer = Question::where('parent_id','!=','0')->first();
        $response = $this->actingAs($this->user)->post("api/user/asnwer/{$answer->id}/score",[
            'type' => 'like',
        ]);
        $response->assertOk();
    }

    function test_add_dislike(): void
    {
        $answer = Question::where('parent_id','!=','0')->first();
        $response = $this->actingAs($this->user)->post("api/user/asnwer/{$answer->id}/score",[
            'type' => 'dislike',
        ]);
        $response->assertOk();
    }
}
