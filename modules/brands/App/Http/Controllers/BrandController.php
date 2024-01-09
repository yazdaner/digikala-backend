<?php

namespace Modules\brands\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\brands\App\Models\Brand;
use Modules\brands\App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
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
    }
}


