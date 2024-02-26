<?php

namespace Modules\brands\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\brands\App\Models\Brand;
use Modules\brands\App\Http\Requests\BrandRequest;
use Modules\core\App\Http\Controllers\CrudController;

class BrandController extends CrudController
{

    protected string $model = Brand::class;

    public function index(Request $request)
    {
        $brands = Brand::search($request->all());
        return [
            'brands' => $brands,
            'trashCount' => Brand::onlyTrashed()->count(),
        ];
    }

    public function store(BrandRequest $request)
    {
        $brand = new Brand($request->all());
        $image = upload_file($request,'icon','upload');
        if($image){
            $brand->icon = $image;
        }
        $brand->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Brand::findOrFail($id);
    }

    public function update($id,BrandRequest $request)
    {
        $data = $request->all();
        $brand = Brand::findOrFail($id);
        $image = upload_file($request,'icon','upload');
        if($image){
            $data['icon'] = $image ;
        }
        $brand->update($data);
        return ['status' => 'ok'];
    }

    public function all()
    {
        return Brand::select(['id','name','en_name'])->get();
    }
}


