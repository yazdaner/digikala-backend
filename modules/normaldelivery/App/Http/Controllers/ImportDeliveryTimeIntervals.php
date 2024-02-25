<?php

namespace Modules\normaldelivery\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Modules\normaldelivery\import\ShippingIntervalsImport;

class ImportDeliveryTimeIntervals extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->file('excel');
        $city_id = $request->post('city_id');
        $fileName = Storage::disk('local')->put('excel', $file);
        Excel::import(new ShippingIntervalsImport($city_id), storage_path('/app/excel/' . $fileName));
        return ['status' => 'ok'];
    }
}
