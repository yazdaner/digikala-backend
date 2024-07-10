<?php

namespace Tests\Feature\shop;

use Tests\TestCase;

class ShopTest extends TestCase
{
    public function test_products(): void
    {
        $response = $this->get('/api/shop/products?variation=true&limit=15');
        \Log::info($response->json());
        $body = $response->json();
        $this->assertGreaterThan(0,sizeof($body));
        $this->assertNotNull($body[0]['variation']);
        $response->assertOk();
    }
}
