<?php

namespace Tests\Feature\shop;

use Tests\TestCase;

class ShopTest extends TestCase
{
    public function test_products(): void
    {
        $response = $this->get('/api/shop/products?limit=15');
        $body = $response->json();
        $this->assertGreaterThan(0,sizeof($body));
        $response->assertOk();
    }
}
