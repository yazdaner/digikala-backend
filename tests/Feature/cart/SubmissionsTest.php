<?php

namespace Tests\Feature\cart;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\cart\App\Models\Submission;

class SubmissionsTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function  test_statistics()
    {
        $response = $this->actingAs($this->user)->get('/api/admin/submissions/statistics');
        $body = $response->json();
        $submissionsCount1 = Submission::where('send_status', 0)->count();
        $submissionsCount2 = Submission::where('send_status', 5)->count();
        $this->assertEquals($submissionsCount1,$body[0]);
        $this->assertEquals($submissionsCount2,$body[5]);
        $response->assertOk();
    }
}
