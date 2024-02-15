<?php

namespace Tests\Feature\galleries;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GallerySettingTest extends TestCase
{
    public function test_set_config_setting(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->post('api/admin/setting/gallery',[
            'image' => UploadedFile::fake()->image('icon.png'),
            'watermark' => 'true',
            'position' => 'bottom-right',
            'position_x' => 15,
            'position_y' => 15,
            'opacity' => 50,
        ]);
        //
        $response->assertOk();
    }

    public function test_get_config_setting(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/setting/gallery');
        $body = json_decode($response->getContent(),true);
        $galleryConfig= config('gallery');
        $this->assertEquals($body['image'],$galleryConfig['image']);
        //
        $response->assertOk();
    }
}
