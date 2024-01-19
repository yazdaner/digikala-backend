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
        $warranty = new Warranty($request->all());
        $image = upload_file($request,'icon','upload');
        if($image){
            $warranty->icon = $image;
        }
        $warranty->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Warranty::findOrFail($id);
    }

    public function update($id,WarrantyRequest $request)
    {
        $data = $request->all();
        $warranty = Warranty::findOrFail($id);
        $warranty->update($data);
        return ['status' => 'ok'];
    }

    public function all()
    {
        return Warranty::select(['id','name','en_name'])->get();
    }
}


