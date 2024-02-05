<?php

namespace Modules\categories\App\Events;

use Illuminate\Support\Facades\DB;
use Modules\categories\App\Models\Category;

class SavingProduct
{
    public function handle($product)
    {
        DB::table('products__categories')
            ->where('product_id', $product->id)->delete();
        $category = Category::find($product->category_id);
        $categories_id = [$product->category_id];

        while ($category != null && $category->parent_id != 0) {
            $categories_id[] = $category->parent_id;
            $category = Category::find($category->parent_id);
        }
        foreach ($categories_id as $category_id) {
            $this->insert($product->id, $category_id);
        }
    }

    protected function insert($product_id, $category_id)
    {
        if ($category_id != null) {
            DB::table('products__categories')
                ->insert([
                    'product_id' => $product_id,
                    'category_id' => $category_id
                ]);
        }
    }
}
