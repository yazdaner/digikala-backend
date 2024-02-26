<?php

namespace Tests\Feature\sliders;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\sliders\App\Models\Slider;

class SliderTest extends TestCase
{

    public function test_create(): void
    {
        $admin = getAdminForTest();
        $slider = Slider::factory()->make();
        $response = $this->actingAs($admin)->post('api/admin/sliders', [
            'title' => $slider->title,
            'url' => $slider->url,
            'image' => UploadedFile::fake()->image('image.png'),
            'mobile_image' => UploadedFile::fake()->image('mobile_image.png')
        ]);
        $latest = Slider::latest('id')->first();
        //
        $this->assertNotNull($latest->title);
        $this->assertNotNull($latest->mobile_image);
        $response->assertOk();
    }

    public function test_show(): void
    {
        $admin = getAdminForTest();
        $slider = Slider::factory()->create();
        $response = $this->actingAs($admin)->get('api/admin/sliders/' . $slider->id);
        $body = json_decode($response->getContent());
        //
        $this->assertEquals($slider->id, $body->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $admin = getAdminForTest();
        $title = Str::random(10);
        $url = fake()->url();
        $slider = Slider::factory()->create();
        $response = $this->actingAs($admin)->put('api/admin/sliders/' . $slider->id, [
            'title' => $title,
            'url' => $url,
            'image' => UploadedFile::fake()->image('image.png'),
            'mobile_image' => UploadedFile::fake()->image('mobile_image.png')
        ]);
        //
        $this->assertDatabaseHas('sliders', [
            'id' => $slider->id,
            'title' => $title,
            'url' => $url,
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $admin = getAdminForTest();
        $response = $this->actingAs($admin)->get('api/admin/sliders');
        $body = json_decode($response->getContent(),true);
        //
        $this->assertArrayHasKey('sliders',$body);
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $admin = getAdminForTest();
        $slider = Slider::factory()->create();
        $response = $this->actingAs($admin)->delete('api/admin/sliders/'.$slider->id);
        $this->assertDatabaseMissing('sliders',[
            'id' => $slider->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_restore(): void
    {
        $admin = getAdminForTest();
        $slider = Slider::factory()->create([
            'deleted_at' => Carbon::now()
        ]);
        $response = $this->actingAs($admin)->post('api/admin/sliders/'.$slider->id.'/restore');
        $this->assertDatabaseHas('sliders',[
            'id' => $slider->id,
            'deleted_at' => null,
        ]);
        $response->assertOk();
    }

    public function test_all(): void
    {
        $response = $this->get('api/sliders/all?group=index');
        $body = json_decode($response->getContent(),true);
        $sliders = Slider::where('group','index')->get();
        $this->assertEquals(sizeof($sliders),sizeof($body));
        $response->assertOk();
    }
}
