<?php

namespace Modules\areas\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\areas\App\Models\City;
use Modules\areas\App\Http\Requests\CityRequest;
use Modules\core\App\Http\Controllers\CrudController;

class CityController extends CrudController
{
    protected string $model = City::class;

    public function index(Request $request): array
    {
        $cities = City::search($request->all());
        return [
            'cities' => $cities,
            'trashCount' => City::onlyTrashed()->count(),
        ];
    }

    public function store(CityRequest $request)
    {
        $city = new City($request->all());
        $city->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return City::findOrFail($id);
    }

    public function update($id, CityRequest $request)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());
        return ['status' => 'ok'];
    }

    public function ProvinceCities($province_id)
    {
        return City::where('province_id',$province_id)->orderBy('id','ASC')->get();
    }

    public function all()
    {
        return City::all();
    }
}
