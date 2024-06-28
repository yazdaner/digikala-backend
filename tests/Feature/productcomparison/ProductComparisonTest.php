<?php

namespace Tests\Feature\productcomparison;

use Tests\TestCase;
use Modules\users\App\Models\User;

class ProductComparisonTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }
    
    public function test_comparison(): void
    {
        $product1 = runEvent('product:query',function($query){
            return $query->select(['id'])->inRandomOrder()->first();
            // return $query->select(['id'])->where('id',1)->first();
        },true);

        $product2 = runEvent('product:query',function($query){
            return $query->select(['id'])->inRandomOrder()->first();
            // return $query->select(['id'])->where('id',16)->first();
        },true);

        $response = $this->get("api/product/compare?product_id[0]=$product1->id&product_id[1]=$product2->id");
        // $body = $response->json();
        // dd($body);
        // $specifications = count($response->json()[0]['specifications']);
        // dd($specifications);
        // $this->assertGreaterThan(0,$specifications);

        $product = count($response->json()[0]['product']);
        $this->assertGreaterThan(0,$product);

        $product2 = count($response->json()[1]['product']);
        $this->assertGreaterThan(1,$product2);
        
        $response->assertOk();
    }
}
