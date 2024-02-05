<?php

namespace Modules\categories\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\categories\App\Http\Actions\AddSpecification;
use Modules\categories\App\Models\Category;
use Modules\categories\App\Models\Specification;

class SpecificationController extends Controller
{

    public function index($category_id)
    {
        $categoriesId = getParentCategoryId($category_id);
        return Specification::where([
            'parent_id' => 0
        ])->whereIn('category_id', $categoriesId)
            ->with('childs');
    }

    public function store(
        $category_id,
        Request $request,
        AddSpecification $addSpecification
    ) {
        Category::findOrFail($category_id);
        $addSpecification($category_id, $request->all());
        return ['status' => 'ok'];
    }

    public function destroy($id)
    {
        Specification::where('id', $id)->delete();
        Specification::where('parent_id', $id)->delete();
        return ['status' => 'ok'];
    }
}
