<?php

namespace Tests\Feature\normaldelivery;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;

class NormalDeliveryTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_setting(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/setting/normal-delivery',[
            'min_buy_free_normal_shipping' => rand(999999,9999999),
            'normal_delivery_time' => rand(1,5),
            'normal_shipping_cost' => rand(9999,99999),
        ]);
        //
        $response->assertOk();
    }

    public function test_get_setting(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/setting/normal-delivery');
        //
        $body = json_decode($response->getContent(),true);
        $this->assertNotEmpty($body['min_buy_free_normal_shipping']);
        $response->assertOk();
    }

    public function test_import_setting(): void
    {
        $path = storage_path('/app/excel/1.xlsx');
        $uploadedFile = new UploadedFile(
            $path,
            '1.xlsx'
        );
        $response = $this->actingAs($this->user)->post('api/admin/setting/normal-delivery/import-time',[
            'city_id' =>1,
            'excel' =>$uploadedFile
        ]);
        //
        $response->assertOk();
    }

    public function test_export_setting(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/setting/normal-delivery/export-time',[
            'city_id' =>1,
        ]);
        //
        $response->assertDownload('shipping-time-intervals.xlsx');
    }
}
