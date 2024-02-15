<?php

namespace Tests\Feature\warranties;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\warranties\App\Models\Warranty;

class WarrantyTest extends TestCase
{

    public function test_create(): void
    {
        $admin = getAdminForTest();
        $warranty = Warranty::factory()->make();
        $response = $this->actingAs($admin)->post('api/admin/warranties', [
            'name' => $warranty->name,
            'link' => $warranty->link,
            'phone_number' => $warranty->phone_number,
        ]);
        //
        $response->assertOk();
    }

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $name = Str::random(10);
        $link = fake()->url();
        $phone_number = fake()->phoneNumber();
        $warranty = Warranty::factory()->create();
        $response = $this->actingAs($admin)->put('api/admin/warranties/' . $warranty->id, [
            'name' => $name,
            'link' => $link,
            'phone_number' => $phone_number,
        ]);
        //
        $this->assertDatabaseHas('warranties', [
            'id' => $warranty->id,
            'name' => $name,
            'link' => $link,
            'phone_number' => $phone_number,
        ]);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $admin = getAdminForTest();
        $warranty = Warranty::factory()->create();
        $response = $this->actingAs($admin)->get('api/admin/warranties/' . $warranty->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($warranty->id, $body->id);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/warranties');
        $body = json_decode($response->getContent(),true);
        //
        $this->assertArrayHasKey('warranties',$body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/warranties?trashed=true&name=app');
        $body = json_decode($response->getContent(),true);
        $count = Warranty::onlyTrashed()->where('name','like','%app%')->count();
        //
        $this->assertEquals($body['warranties']['total'],$count);
        $this->assertArrayHasKey('warranties',$body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $admin = getAdminForTest();
        $warranty = Warranty::factory()->create();
        $response = $this->actingAs($admin)->delete('api/admin/warranties/'.$warranty->id);
        $this->assertDatabaseMissing('warranties',[
            'id' => $warranty->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $warranty = Warranty::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($admin)->post('api/admin/warranties/'.$warranty->id.'/restore');
        $this->assertDatabaseHas('warranties',[
            'id' => $warranty->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
}
