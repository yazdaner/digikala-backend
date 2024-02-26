<?php

namespace Modules\areas\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\areas\App\Models\Province;
use Modules\areas\App\Http\Requests\ProvinceRequest;
use Modules\core\App\Http\Controllers\CrudController;

class ProvinceController extends CrudController
{
    protected string $model = Province::class;

    public function index(Request $request): array
    {
        $provinces = Province::search($request->all());
        return [
            'provinces' => $provinces,
            'trashCount' => Province::onlyTrashed()->count(),
        ];
    }

    public function store(ProvinceRequest $request)
    {
        $province = new Province($request->all());
        $province->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Province::findOrFail($id);
    }

    public function update($id, ProvinceRequest $request)
    {
        $province = Province::findOrFail($id);
        $province->update($request->all());
        return ['status' => 'ok'];
    }

    public function all()
    {
        return Province::orderBy('id','ASC')->get();
    }
}
