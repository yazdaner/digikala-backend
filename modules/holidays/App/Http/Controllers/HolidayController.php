<?php

namespace Modules\holidays\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\holidays\App\Models\Holiday;
use Modules\holidays\App\Http\Requests\HolidayRequest;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $holidays = Holiday::search($request->all());
        return [
            'holidays' => $holidays,
            'trashCount' => Holiday::onlyTrashed()->count(),
        ];
    }

    public function store(HolidayRequest $request)
    {
        $brand = new Holiday($request->all());
        $image = upload_file($request, 'icon', 'upload');
        if ($image) {
            $brand->icon = $image;
        }
        $brand->saveOrFail();
        return ['status' => 'ok'];
    }
}
