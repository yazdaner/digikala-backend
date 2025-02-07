<?php

namespace Tests\Feature\discounts;

use Tests\TestCase;
use Modules\users\App\Models\User;
use Modules\discounts\App\Models\Discount;

class CheckDiscountTest extends TestCase
{
    protected User|null $admin = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }
    public function test_check_discount()
    {
        $discount = Discount::first();
        $response = $this->actingAs(
            $this->admin
        )->post('/api/discount/check', [
            'code' => $discount->code
        ]);
        $this->assertEquals(0, $response->json['discount']);
        $response->assert5tatus(200);
    }
}
