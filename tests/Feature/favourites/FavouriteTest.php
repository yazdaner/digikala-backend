<?php

namespace Tests\Feature\favourites;

use Modules\favourites\App\Models\Favourite;
use Tests\TestCase;
use Modules\users\App\Models\User;

class FavouriteTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_favourite(): void
    {
        $product = runEvent('product:query',function ($query) {
            return $query->select(['id'])->inRandomOrder()->first();
        },true);

        $response = $this->actingAs($this->user)->get("api/user/product/{$product->id}/favourite/add");
        $response->assertOk();
    }

    public function test_check_added(): void
    {
        $favourite = Favourite::where('user_id',$this->user->id)->first();
        $response = $this->actingAs($this->user)->get("api/user/product/{$favourite->product_id}/favourite/check");
        $data = $response->json();
        $this->assertEquals('true',$data['added']);
        $response->assertOk();
    }

    public function test_favourites_list(): void
    {
        $response = $this->actingAs($this->user)->get("api/user/favourites");
        $data = $response->json();
        $this->assertArrayHasKey('links',$data);
        $this->assertArrayHasKey('last_page',$data);
        $this->assertArrayHasKey('data',$data);
        $response->assertOk();
    }

    public function test_remove_favourite(): void
    {
        $favourite = Favourite::where('user_id',$this->user->id)->first();
        $response = $this->actingAs($this->user)->delete("api/user/product/{$favourite->product_id}/favourite/remove");
        $this->assertDatabaseMissing('favourites',[
            'user_id' => $this->user,
            'product_id' => $favourite->product_id
        ]);
        $response->assertOk();
    }
}
