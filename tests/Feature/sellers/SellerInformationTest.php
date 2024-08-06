<?php

namespace Tests\Feature\sellers;

use Tests\TestCase;
use Modules\sellers\App\Models\Seller;
use Modules\core\App\Models\VerificationCode;

class SellerInformationTest extends TestCase
{
    protected Seller $seller;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::inRandomOrder()->first();
    }

    public function test_update_name(): void
    {
        $response = $this->actingAs($this->seller, 'seller')
            ->post(
                'api/seller/profile/update-information/name',
                [
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName()
                ]
            );
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    // public function test_update_national_code(): void
    // {
    //     $response = $this->actingAs($this->seller, 'seller')
    //         ->post(
    //             'api/seller/profile/update-information/national-code',
    //             [
    //                 'nationalCode' => 2586227948,
    //             ]
    //         );
    //     $response->assertOk()
    //         ->assertJson(['status' => 'ok']);
    // }

    public function test_request_update_email()
    {
        $response = $this->actingAs($this->seller, 'seller')
            ->post(
                'api/seller/profile/request-update/email',
                [
                    'email' => fake()->email(),
                ]
            );
        $this->assertArrayHasKey('encrypted', $response->json());
        $response->assertOk();
        return $response->json()['encrypted'];
    }

    /**
     * @depends test_request_update_email
     */

    public function test_update_email($encrypted): void
    {
        $row = VerificationCode::where([
            'tableable_type' => Seller::class,
            'tableable_id' => $this->seller->id
        ])->first();
        $response = $this->actingAs($this->seller, 'seller')
            ->post(
                'api/seller/profile/update-information/email',
                [
                    'encrypted' => $encrypted,
                    'code' => $row->code
                ]
            );
        $response->assertOk();
    }

    public function test_notification_mobile(): void
    {
        $response = $this->actingAs($this->seller, 'seller')
            ->post(
                'api/seller/profile/update-information/notification-mobile',
                [
                    'notification-mobile' => '09123456789'
                ]
            );
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_shop_about(): void
    {
        $response = $this->actingAs($this->seller, 'seller')
            ->post(
                'api/seller/profile/update-information/shop-about',
                [
                    'shop_about' => fake()->paragraph()
                ]
            );
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_shop_website(): void
    {
        $response = $this->actingAs($this->seller, 'seller')
            ->post(
                'api/seller/profile/update-information/shop-website',
                [
                    'shop_website' => fake()->url()
                ]
            );
        $response->assertOk()
            ->assertJson(['status' => 'ok']);
    }
}
