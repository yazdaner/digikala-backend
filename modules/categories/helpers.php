<?php

use Modules\categories\App\Models\Category;

function getParentCategoryId($categoryId)
{
    $array = [];
    $category = Category::find($categoryId);
    if ($category) {
        $array[] = $category->id;
        while ($category->parent_id != 0) {
            $category = Category::where('id', $category->parent_id)->first();
            if ($category) {
                $array[] = $category->id;
            }
        }
    }
    return $array;
}
