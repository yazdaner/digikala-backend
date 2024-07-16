<?php

namespace Tests\Feature\setting;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;

class SettingTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_web_service_setting(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/setting/web-services', [
            'gateway' => 'zarinpal',
        ]);
        $response->assertOk();
    }
    public function test_add_web_service_info(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/setting/web-services');
        $data = $response->json();
        $this->assertArrayHasKey('gateway',$data);
        $this->assertNotNull($data['gateway']);
        $response->assertOk();
    }

    public function test_add_shop_info(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/setting/shop',[
            'name' => 'yazdan shop',
            'icon' =>  UploadedFile::fake()->image('icon.png'),
            'multi-seller' => 'true',
            'tags' => 'فروشگاه لوازم جانبی',
            'description' => 'test'
        ]);
        $response->assertOk();
    }

    public function test_get_shop_info(): void
    {
        $response = $this->actingAs($this->user)->get('api/setting/shop');
        $data = $response->json();
        $this->assertArrayHasKey('name',$data);
        $this->assertEquals($data['name'],'yazdan shop');
        $response->assertOk();
    }
}
