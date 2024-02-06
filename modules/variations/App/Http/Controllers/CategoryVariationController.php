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
}
