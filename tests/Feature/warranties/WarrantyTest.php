<?php

namespace Tests\Feature\warranty;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\warranties\App\Models\Warranty;

class WarrantyTest extends TestCase
{

    public function test_create(): void
    {
        $warranty = Warranty::factory()->make();
        $response = $this->post('api/admin/warranties', [
            'name' => $warranty->name,
            'link' => $warranty->link,
            'phone_number' => $warranty->phone_number,
        ]);
        //
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(10);
        $link = fake()->url();
        $phone_number = fake()->phoneNumber();
        $warranty = Warranty::factory()->create();
        $response = $this->put('api/admin/warranties/' . $warranty->id, [
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
        $warranty = Warranty::factory()->create();
        $response = $this->get('api/admin/warranties/' . $warranty->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($warranty->id, $body->id);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->get('api/admin/warranties');
        $body = json_decode($response->getContent(),true);
        //
        $this->assertArrayHasKey('warranties',$body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->get('api/admin/warranties?trashed=true&name=app');
        $body = json_decode($response->getContent(),true);
        $count = Warranty::onlyTrashed()->where('name','like','%app%')->count();
        //
        $this->assertEquals($body['warranties']['total'],$count);
        $this->assertArrayHasKey('warranties',$body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $warranty = Warranty::factory()->create();
        $response = $this->delete('api/admin/warranties/'.$warranty->id);
        $this->assertDatabaseMissing('warranties',[
            'id' => $warranty->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $warranty = Warranty::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->post('api/admin/warranties/'.$warranty->id.'/restore');
        $this->assertDatabaseHas('warranties',[
            'id' => $warranty->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
}
