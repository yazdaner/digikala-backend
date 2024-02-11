<?php

namespace Tests\Feature\galleries;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    public function test_upload(): void
    {
        $request = Request::create('/upload-file', 'post', [
            'files' => [
                'image1' => UploadedFile::fake()->image('icon.png'),
                'image2' => UploadedFile::fake()->image('icon.png')
            ]
        ]);
        $result = runEvent('gallery:upload', $request, true);
        $this->assertEquals(sizeof($result),2);
    }
}
