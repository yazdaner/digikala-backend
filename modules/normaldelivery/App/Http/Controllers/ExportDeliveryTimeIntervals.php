<?php

namespace Modules\normaldelivery\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\normaldelivery\export\ShippingIntervalsExport;

class ExportDeliveryTimeIntervals extends Controller
{
    public function __invoke(Request $request)
    {
        return Excel::download(new ShippingIntervalsExport($request->post('city_id')), 'shipping-time-intervals.xlsx');
    }
}
