<?php

namespace Tests\Feature\variations;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
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

    public function test_update_variation(): void
    {
        $uploadedFile = new UploadedFile(
            storage_path('/app/excel/variations.xlsx'),
            'variations.xlsx',
            null,
            null,
            true
        );
        $response = $this->actingAs($this->user)->post('api/admin/variations/update',[
            'file' => $uploadedFile
        ]);
        //
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
