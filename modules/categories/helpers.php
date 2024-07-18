<?php

use Modules\categories\App\Models\Category;

function getParentCategoryId($categoryId): array
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

function getChildCategoriesId($categoryId): array
{
    $array = [];
    $category = Category::find($categoryId);
    if ($category) {
        $array = [$categoryId];
        for ($i = 0; $i < 3; $i++) {
            $categories = Category::whereIn('parent_id', $array)
                ->whereNotIn('id', $array)
                ->pluck('id')
                ->toArray();
            $array = array_merge($array, $categories);
        }
    }
    return $array;
}
