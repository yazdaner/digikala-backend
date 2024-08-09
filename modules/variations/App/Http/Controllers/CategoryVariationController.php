<?php

namespace Modules\variations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\variations\App\Models\CategoryVariation;

class CategoryVariationController extends Controller
{
    public function index($category_id)
    {
        return CategoryVariation::where('category_id', $category_id)
            ->first();
    }

    public function store($category_id, Request $request)
    {
        CategoryVariation::updateOrCreate(
            [
                'category_id' => $category_id
            ],
            [
                'item1' => $request->post('item1'),
                'item2' => $request->post('item2')
            ]
        );
    }

    public function items($category_id)
    {
        $result = [];
        $categoriesId = getParentCategoryId($category_id);
        foreach ($categoriesId as $id) {
            if (sizeof($result) == 0) {
                $variationItems = CategoryVariation::where('category_id', $id)
                    ->first();
                if ($variationItems) {
                    if ($variationItems->item1) {
                        $result[0] =  $variationItems->item1::itemsDetail();
                    }
                    if ($variationItems->item2) {
                        $result[1] =  $variationItems->item2::itemsDetail();
                    }
                }
            }
        }
        return $result;
    }
}
