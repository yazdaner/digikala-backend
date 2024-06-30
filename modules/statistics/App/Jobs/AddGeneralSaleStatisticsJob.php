<?php

namespace Modules\statistics\App\Jobs;

use Modules\core\Lib\Jdf;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Modules\statistics\App\Models\GeneralSaleStatistic;

class AddGeneralSaleStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $jdf = new Jdf();
        $year = $jdf->jdate('Y');
        $month = $jdf->jdate('n');
        $day = $jdf->jdate('j');

        $row = GeneralSaleStatistic::where([
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ])->first();
        if ($row) {
            $row->increment('order_count');
            $row->increment('total_sales', $this->order->final_price);
        } else {
            GeneralSaleStatistic::create([
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'order_count' => 1,
                'total_sales' => $this->order->final_price,
            ]);
        }
    }
}
