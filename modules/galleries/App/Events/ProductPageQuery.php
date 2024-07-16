<?php

namespace Modules\galleries\App\Events;

use Modules\products\App\Models\Product;

class ProductPageQuery
{
    public function handle($query)
    {
        if(!defined('gallery_tableable_type')){
            define('gallery_tableable_type',Product::class);
        }
        return $query->with('gallery');
    }
}
