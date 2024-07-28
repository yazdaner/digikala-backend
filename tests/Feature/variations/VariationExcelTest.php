<?php

namespace Tests\Feature\variations;

use Tests\TestCase;
use Illuminate\Foundation\Auth\User;

class VariationExcelTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_export(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/variations/export');
        //
        $response->assertOk()
            ->assertDownload('variations.xlsx');
    }
}
