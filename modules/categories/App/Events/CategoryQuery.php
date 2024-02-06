<?php

namespace Modules\categories\App\Events;

use Modules\categories\App\Models\Category;

class CategoryQuery
{
    public function handle($function)
    {
        $category = Category::query();
        return $function($category);
    }
}
