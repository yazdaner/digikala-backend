<?php

namespace Tests\Feature\color;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\users\App\Models\User;
use Modules\colors\App\Models\Color;

class ColorTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }
    
    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/colors');
        $body = json_decode($response->getContent(),true);
        //
        $this->assertArrayHasKey('colors',$body);
        $response->assertOk();
    }

    public function test_index_search(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/colors?trashed=true&name=app');
        $body = json_decode($response->getContent(),true);
        $count = Color::onlyTrashed()->where('name','like','%app%')->count();
        //
        $this->assertEquals($body['colors']['total'],$count);
        $this->assertArrayHasKey('colors',$body);
        $response->assertOk();
    }

    public function test_store(): void
    {
        $color = Color::factory()->make();
        $response = $this->actingAs($this->user)->post('api/admin/colors',[
            'name' => $color->name,
            'code' => $color->code,
        ]);
        $color = Color::latest()->first();
        //
        $response->assertOk();
    }

    public function test_show(): void
    {
        $color = Color::factory()->create();
        $response = $this->actingAs($this->user)->get('api/admin/colors/'.$color->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($color->id,$body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $name = Str::random(10);
        $code = Str::random(10);
        $color = Color::factory()->create();
        $response = $this->actingAs($this->user)->put('api/admin/colors/'.$color->id,[
            'name' => $name,
            'code' => $code,
        ]);
        //
        $this->assertDatabaseHas('colors',[
            'id' => $color->id,
            'name' => $name,
            'code' => $code,
        ]);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $color = Color::factory()->create();
        $response = $this->actingAs($this->user)->delete('api/admin/colors/'.$color->id);
        $this->assertDatabaseMissing('colors',[
            'id' => $color->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $color = Color::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($this->user)->post('api/admin/colors/'.$color->id.'/restore');
        $this->assertDatabaseHas('colors',[
            'id' => $color->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }
}
