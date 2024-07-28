<?php

namespace Modules\sizes\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\sizes\App\Models\Size;
use Modules\sizes\App\Http\Requests\SizeRequest;
use Modules\core\App\Http\Controllers\CrudController;

class SizeController extends CrudController
{

    protected $model = Size::class;

    public function index(Request $request)
    {
        $sizes = Size::search($request->all());
        return [
            'sizes' => $sizes,
            'trashCount' => Size::onlyTrashed()->count(),
        ];
    }

    public function store(SizeRequest $request)
    {
        $size = new Size($request->all());
        $size->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Size::findOrFail($id);
    }

    public function update($id,SizeRequest $request)
    {
        $data = $request->all();
        $size = Size::findOrFail($id);
        $size->update($data);
        return ['status' => 'ok'];
    }
}


