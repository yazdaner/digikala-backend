<?php

namespace Tests\Feature\variations;

use Tests\TestCase;
use Illuminate\Foundation\Auth\User;
use Modules\products\App\Models\Product;
use Modules\variations\App\Models\SalesLock;

class SalesLockTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->post('api/admin/products-locked',[
            'category_id' => 0,
            'brand_id' => 0,
            'description' => fake()->paragraph()
        ]);
        //
        $response->assertOk();
    }

    public function test_show(): void
    {
        $lock = SalesLock::select(['id'])->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->get('api/admin/products-locked/'.$lock->id);
        //
        $this->assertEquals($response->json()['id'],$lock->id);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $lock = SalesLock::inRandomOrder()->first();
        $data = $lock->toArray();
        $description = fake()->paragraph();
        $data['description'] = $description;
        $response = $this->actingAs($this->user)->put('api/admin/products-locked/'.$lock->id,$data);
        //
        $this->assertDatabaseHas('products__sales_lock',[
            'id' => $lock->id,
            'description' => $description,
        ]);
        $response->assertOk();
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get('api/admin/products-locked');
        //
        $this->assertGreaterThan(0,sizeof($response->json()['data']));
        $response->assertOk();
    }

    public function test_check_locked(): void
    {
        $product = Product::select(['id'])->first();
        $response = $this->actingAs($this->user)->get("api/product/$product->id/lock-description");
        $this->assertNotNull($response->json());
        $response->assertOk();
    }

    public function test_destroy(): void
    {
        $lock = SalesLock::select(['id'])->inRandomOrder()->first();
        $response = $this->actingAs($this->user)->delete('api/admin/products-locked/' . $lock->id);
        $this->assertDatabaseMissing('products__sales_lock', [
            'id' => $lock->id,
        ]);
        $response->assertOk();
    }
}
