<?php

namespace Modules\holidays\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\holidays\App\Models\Holiday;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\holidays\App\Http\Requests\HolidayRequest;

class HolidayController extends CrudController
{
    protected $model = Holiday::class;

    public function index(Request $request)
    {
        $shop_id = $request->has('shop_id') ? $request->get('shop_id') : 0;
        return Holiday::where('shop_id', $shop_id)->get();
    }

    public function store(HolidayRequest $request)
    {
        Holiday::where('date', $request->get('date'))->delete();
        $holiday = new Holiday($request->all());
        $arr = explode('/',$request->get('date'));
        $holiday->timestamp = timestamp($arr[0],$arr[1],$arr[2]);
        $holiday->saveOrFail();
        return ['status' => 'ok'];
    }
}
