<?php

namespace Tests\Feature\products;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;

class ProductGalleryTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_upload()
    {
        $response = $this->actingAs($this->user)->post('api/admin/products/gallery', [
            'files' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ]
        ]);
        //
        $response->assertOk();
        return $response->json()['paths'];
    }

    /**
     * @depends test_upload
     */

    public function test_destroy($paths)
    {
        $response = $this->actingAs($this->user)->delete('api/admin/product/gallery', [
            'path' => $paths[0]
        ]);
        //
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
