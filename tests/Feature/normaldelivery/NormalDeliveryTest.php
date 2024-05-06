<?php

namespace Tests\Feature\normaldelivery;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class NormalDeliveryTest extends TestCase
{
    public function test_add_setting(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->post('api/admin/setting/normal-delivery',[
            'min_buy_free_normal_shipping' => rand(999999,9999999),
            'normal_delivery_time' => rand(1,5),
            'normal_shipping_cost' => rand(9999,99999),
        ]);
        //
        $response->assertOk();
    }

    public function test_get_setting(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/setting/normal-delivery');
        //
        $body = json_decode($response->getContent(),true);
        $this->assertNotEmpty($body['min_buy_free_normal_shipping']);
        $response->assertOk();
    }

    public function test_import_setting(): void
    {
        $admin = getAdminForTest();
        $path = storage_path('/app/excel/1.xlsx');
        $uploadedFile = new UploadedFile(
            $path,
            '1.xlsx'
        );
        $response = $this->actingAs($admin)->post('api/admin/setting/normal-delivery/import-time',[
            'city_id' =>1,
            'excel' =>$uploadedFile
        ]);
        //
        $response->assertOk();
    }

    public function test_export_setting(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->post('api/admin/setting/normal-delivery/export-time',[
            'city_id' =>1,
        ]);
        //
        $response->assertDownload('shipping-time-intervals.xlsx');
    }
}
