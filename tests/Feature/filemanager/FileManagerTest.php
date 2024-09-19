<?php

namespace Tests\Feature\brands;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Illuminate\Support\Facades\File;

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
        return ($path . '/' . $filename);
    }

    /**
     *  @depends test_upload
     */

    public function test_remove_file($file)
    {
        $response = $this->actingAs($this->user)->post('api/admin/filemanager/remove', [
            'file' => $file
        ]);
        //
        $this->assertFileDoesNotExist(fileDirectory($file));
        $response->assertOk()->assertJson(['status' => 'ok']);
    }


    public function test_slice_upload_file()
    {
        $content = str_repeat('video', 1024 * 1024);
        $filePath = storage_path('app/public/test_video.mp4');
        File::put($filePath, $content);
        $partSize = 0.5  * 1024 * 1024;
        $partCount = ceil(strlen($content) / $partSize);
        for ($part = 1; $part <= $partCount; $part++) {
            $start = ($part - 1) * $partSize;
            $sliceContent = substr($content, $start, $partSize);
            $tempFilePath = storage_path('app/public/temp-slice-' . $part . '.mp4');
            File::put($tempFilePath, $sliceContent);
            $response = $this->actingAs($this->user)->post('/api/admin/filemanager/upload-slice', [
                'fileDirectory' => '/video',
                'part' => $part,
                'file' =>  new UploadedFile(
                    $tempFilePath,
                    'test.mp4',
                    'video/mp4',
                    null,
                    true
                ),
                'lasted' => $part == $partCount ? 'true' : 'false'
            ]);
            $response->assertOk()->assertJson(['status' => 'ok']);
            File::delete($tempFilePath);
        }
    }

    public function test_filemanager()
    {
        $response = $this->actingAs($this->user)->get('api/admin/filemanager?path="/"');
        //
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertOk();
    }
}
