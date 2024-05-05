<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\users\App\Models\User;

class SubmissionTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getUserForTest();
    }

    public function  test_return_submission_info(): void
    {
        $address = runEvent('address-detail', ['user_id' => $this->user->id], true);
        $response = $this->actingAs($this->user)->get("/api/user/card/submissions?address_id=$address->id");
        // \Log::info(var_export($response->getContent(),true));
        $response->assertStatus(200);
    }
}
