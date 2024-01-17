<?php

namespace Modules\categories\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\categories\App\Models\Category;
use Modules\categories\App\Http\Requests\CategoryRequest;
use Modules\core\App\Http\Controllers\CrudController;

class CategoryController extends CrudController
{

    protected $model = Category::class;

    public function index(Request $request)
    {
        $categories = Category::search($request->all());
        return [
            'categories' => $categories,
            'trashCount' => Category::onlyTrashed()->count(),
        ];
    }

    public function store(CategoryRequest $request)
    {
        $category = new Category($request->all());
        $category->slug = replaceSpace($request->get('en_name'));
        $image = upload_file($request,'image','upload');
        if($image){
            $category->image = $image;
        }
        $nonsignificant = $request->get('nonsignificant') == 'true' ? 1 : 0;
        $category->nonsignificant = $nonsignificant;
        $category->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update($id,CategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::findOrFail($id);
        $category->slug = replaceSpace($request->get('en_name'));
        $image = upload_file($request,'image','upload');
        if($image){
            $category->image = $image;
        }
        $nonsignificant = $request->get('nonsignificant') == 'true' ? 1 : 0;
        $category->nonsignificant = $nonsignificant;
        unset($data['nonsignificant']);
        $category->update($data);
        return ['status' => 'ok'];
    }

    public function all()
    {
        return Category::all();
    }
}
