<?php

namespace Tests\Feature\brands;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Modules\users\App\Models\User;

class FileManagerTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create_folder()
    {
        $path = '/test/' . fake()->word;
        $response = $this->actingAs($this->user)->post('api/admin/filemanager/create-folder', [
            'path' => $path,
        ]);
        //
        $response->assertOk();
        return $path;
    }

    /**
     *  @depends test_create_folder
     */

    public function test_upload($path)
    {
        $response = $this->actingAs($this->user)->post('api/admin/filemanager/upload', [
            'fileDirectory' => $path,
            'file' => UploadedFile::fake()->image('file.png')
        ]);
        //
        $filename = $response->json()['filename'];
        $this->assertFileExists(fileDirectory($path . '/' . $filename));
        $response->assertOk();
    }
}
