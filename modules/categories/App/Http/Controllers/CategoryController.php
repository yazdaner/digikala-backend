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
        $brand = new Category($request->all());
        $image = upload_file($request,'icon','upload');
        if($image){
            $brand->icon = $image;
        }
        $brand->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update($id,CategoryRequest $request)
    {
        $data = $request->all();
        $brand = Category::findOrFail($id);
        $image = upload_file($request,'icon','upload');
        if($image){
            $data['icon'] = $image ;
        }
        $brand->update($data);
    }

    public function all()
    {
        return Category::select(['id','name','en_name'])->get();
    }
}
