<?php

namespace Modules\statistics\App\Http\Controllers;

use Modules\core\Lib\Jdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\statistics\App\Models\ProductsSaleStatistic;

class ProductSaleController extends Controller
{
    public function __invoke(Request $request)
    {
        $product_id = $request->get('product_id');
        $jdf = new Jdf();
        $year = $request->get('year')  != '' ? $request->get('year') : $jdf->tr_num($jdf->jdate('Y'));
        if ($request->get('month') != '') {
            $month = $request->get('month');
            // count of days of a month 30-31-29
            $t = $jdf->tr_num($jdf->jdate('t', timestamp($year, $month, 1)));
            $saleStatistics = ProductsSaleStatistic::where([
                'year' => $year,
                'month' => $month,
                'product_id' => $product_id
            ])->orderBy('day', 'ASC')
                ->get();
            $saleData = array_fill(0, $t, 0);
            $countData = array_fill(0, $t, 0);
            foreach ($saleStatistics as $value) {
                $saleData[($value->day - 1)] = $saleData[($value->day - 1)] + $value->total_sales;
                $countData[($value->day - 1)] = $countData[($value->day - 1)] + $value->order_count;
            }
        } else {
            $saleStatistics = ProductsSaleStatistic::where([
                'year' => $year,
                'product_id' => $product_id,
            ])->orderBy('month', 'ASC')
                ->get();
            $saleData = array_fill(0, 12, 0);
            $countData = array_fill(0, 12, 0);
            foreach ($saleStatistics as $value) {
                $saleData[($value->month - 1)] = $saleData[($value->month - 1)] + $value->total_sales;
                $countData[($value->month - 1)] = $countData[($value->month - 1)] + $value->order_count;
            }
        }
        return [
            'saleData' => $saleData,
            'countData' => $countData,
            'years' => $this->getYearsList(),
            'year' => $year
        ];
    }

    protected function getYearsList()
    {
        return ProductsSaleStatistic::orderBy('year', 'ASC')
            ->select('year')
            ->distinct()
            ->pluck('year')
            ->toArray();
    }
}
