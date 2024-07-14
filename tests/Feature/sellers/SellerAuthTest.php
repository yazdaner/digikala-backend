<?php

namespace Tests\Feature\sellers;

use Tests\TestCase;
use Modules\sellers\App\Models\Seller;
use Modules\core\App\Models\VerificationCode;

class SellerAuthTest extends TestCase
{
    public function test_sign_in(): void
    {
        $username = fake()->email;
        $response = $this->post('api/seller/sign-in',[
            'username' => $username,
        ]);
        //
        // \Log::info($response->json());
        $this->assertEquals('register',$response->json()['status']);
        $response->assertOk();
    }

    public function test_verify_for_register(): void
    {
        $seller = Seller::where([
            'status' => -3
        ])->orderBy('id','DESC')->first();

        $verification = VerificationCode::where([
            'tableable_id' => $seller->id,
            'tableable_type' => Seller::class
        ])->first();

        $response = $this->post('/api/seller/active-code/verify',[
            'username' => $seller->username,
            'code' => $verification->code
        ]);
        $this->assertEquals('ok',$response->json()['status']);
        $response->assertOk();
    }
}
