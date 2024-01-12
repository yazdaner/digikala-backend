<?php

namespace Modules\warranties\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\warranties\App\Models\Warranty;
use Modules\warranties\App\Http\Requests\WarrantyRequest;
use Modules\core\App\Http\Controllers\CrudController;

class WarrantyController extends CrudController
{

    protected $model = Warranty::class;

    public function index(Request $request)
    {
        $warranties = Warranty::search($request->all());
        return [
            'warranties' => $warranties,
            'trashCount' => Warranty::onlyTrashed()->count(),
        ];
    }

    public function store(WarrantyRequest $request)
    {
        $brand = new Warranty($request->all());
        $image = upload_file($request,'icon','upload');
        if($image){
            $brand->icon = $image;
        }
        $brand->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Warranty::findOrFail($id);
    }

    public function update($id,WarrantyRequest $request)
    {
        $data = $request->all();
        $brand = Warranty::findOrFail($id);
        $image = upload_file($request,'icon','upload');
        if($image){
            $data['icon'] = $image ;
        }
        $brand->update($data);
    }

    public function all()
    {
        return Warranty::select(['id','name','en_name'])->get();
    }
}


