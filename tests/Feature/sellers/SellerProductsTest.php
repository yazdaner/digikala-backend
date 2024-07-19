<?php

namespace Tests\Feature\sellers;

use Modules\sellers\App\Models\Seller;
use Tests\TestCase;

class SellerProductsTest extends TestCase
{
    protected Seller $seller;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::inRandomOrder()->first();
    }

  
}
