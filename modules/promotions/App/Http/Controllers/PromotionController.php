<?php

namespace Modules\promotions\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\promotions\App\Models\Promotion;
use Modules\core\App\Http\Controllers\CrudController;

class PromotionController extends CrudController
{
    protected string $model = Promotion::class;

    public function index(Request $request): array
    {
        $cities = Promotion::search($request->all());
        return [
            'cities' => $cities,
            'trashCount' => Promotion::onlyTrashed()->count(),
        ];
    }

    public function store(Request $request)
    {
        $city = new Promotion($request->all());
        $city->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Promotion::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $city = Promotion::findOrFail($id);
        $city->update($request->all());
        return ['status' => 'ok'];
    }

    public function info()
    {
        return Promotion::all();
    }
}
