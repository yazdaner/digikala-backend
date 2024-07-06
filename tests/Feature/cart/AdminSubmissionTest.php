<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\cart\App\Models\Submission;
use Modules\users\App\Models\User;

class AdminSubmissionTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function  test_change_status(): void
    {
        $submission = Submission::where('send_status', 0)->select('id')->first();
        $response = $this->actingAs($this->user)->post("/api/admin/submission/{$submission->id}/change-status", [
            'status' => 5
        ]);
        $updated = Submission::where('id', $submission->id)->first();
        $this->assertEquals($updated->send_status, 5);
        $response->assertOk();
    }

    public function test_submission_info(): void
    {
        $submission = Submission::inRandomOrder()->first();
        $response = $this->actingAs($this->user)->get("/api/admin/submission/{$submission->id}/info");
        $this->assertGreaterThan(0,sizeof($response->json()['items']));
        $this->assertNotNull($response->json()['items'][0]['product']);
        $this->assertNotNull($response->json()['order']['address']);
        $response->assertOk();
    }

    public function  test_submission_list(): void
    {
        $response = $this->actingAs($this->user)->get("/api/admin/submissions");
        $body = $response->json();
        $this->assertGreaterThan(0,sizeof($body['data']));
        $response->assertOk();
    }
}
