<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\ProductKeyword;

class ProductsIdBasedTag
{
    public function handle($tag)
    {
        $searchTexts = preg_split('/\s+/', $tag);
        return ProductKeyword::where(function ($query) use ($searchTexts) {
            foreach ($searchTexts as $text) {
                $query->where('tag', 'like', '%' . $text . '%');
            }
        })->distinct()->pluck('product_id')->toArray();
    }
}
