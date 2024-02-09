<?php

namespace Modules\colors\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\colors\App\Models\Color;
use Modules\colors\App\Http\Requests\ColorRequest;
use Modules\core\App\Http\Controllers\CrudController;

class ColorController extends CrudController
{

    protected $model = Color::class;

    public function index(Request $request)
    {
        $colors = Color::search($request->all());
        return [
            'colors' => $colors,
            'trashCount' => Color::onlyTrashed()->count(),
        ];
    }

    public function store(ColorRequest $request)
    {
        $color = new Color($request->all());
        $color->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Color::findOrFail($id);
    }

    public function update($id,ColorRequest $request)
    {
        $data = $request->all();
        $color = Color::findOrFail($id);
        $color->update($data);
        return ['status' => 'ok'];
    }
}


