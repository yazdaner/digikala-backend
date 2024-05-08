<?php

namespace Tests\Feature\galleries;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;

class GallerySettingTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }
    
    public function test_set_config_setting(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/setting/gallery',[
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
        $response = $this->actingAs($this->user)->get('api/admin/setting/gallery');
        $body = json_decode($response->getContent(),true);
        $galleryConfig= config('gallery');
        $this->assertEquals($body['image'],$galleryConfig['image']);
        //
        $response->assertOk();
    }
}
