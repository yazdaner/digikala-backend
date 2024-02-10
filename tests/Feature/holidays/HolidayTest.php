<?php

namespace Tests\Feature\holidays;

use Tests\TestCase;
use Modules\holidays\App\Models\Holiday;

class HolidayTest extends TestCase
{
    public function test_create(): void
    {
        $data = Holiday::factory()->make()->toArray();
        $response = $this->post('api/admin/setting/holiday',$data);
        //
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->get('api/admin/setting/holiday');
        $body = json_decode($response->getContent(), true);
        $data = Holiday::get();
        //
        $this->assertEquals(sizeof($data), sizeof($body));
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $holiday = Holiday::factory()->create();
        $response = $this->delete("api/admin/setting/holiday/{$holiday->id}/destroy");
        $this->assertDatabaseMissing('holidays', [
            'id' => $holiday->id,
        ]);
        //
        $response->assertOk();
    }
}
