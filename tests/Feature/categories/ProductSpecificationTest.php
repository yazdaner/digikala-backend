<?php

namespace Tests\Feature\categories;

use Tests\TestCase;
use Illuminate\Support\Str;
use Modules\products\App\Models\Product;
use Modules\categories\App\Models\Specification;

class ProductSpecificationTest extends TestCase
{

    public function test_add_specifications_to_product(): void
    {
        $product = Product::first();
        if ($product) {
            $request = request();
            $values = [];
            $specifications = Specification::where('parent_id', 0)->with('childs')->get();
            foreach ($specifications as $key => $specification) {
                if (sizeof($specification->childs) > 0) {
                    foreach ($specification->childs as $key => $child) {
                        $values[$specification->id . '_' . $child->id] = (($key % 2) == 0);
                    }
                } else {
                    $values[$specification->id] = Str::random(10);
                }
            }
            $request->merge([
                'Specification' => $values
            ]);
            runEvent('product.updated', $product);
        }

        $this->assertDatabaseHas('products__specifications', [
            'product_id' => $product->id
        ]);
    }
}
