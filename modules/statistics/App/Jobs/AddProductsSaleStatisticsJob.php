<?php

namespace Modules\statistics\App\Jobs;

use Modules\core\Lib\Jdf;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Modules\statistics\App\Models\ProductsSaleStatistic;

class AddProductsSaleStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $products = runEvent('order:products', $this->order->id, true);

        if ($products != null && sizeof($products) > 0) {
            foreach ($products as $product) {
                $this->addStatistics($product);
            }
        }
    }

    protected function addStatistics($data): void
    {
        $jdf = new Jdf();
        $year = $jdf->jdate('Y');
        $month = $jdf->jdate('n');
        $day = $jdf->jdate('j');

        runEvent('product:query', function ($query) use ($data) {
            return $query->where('id', $data->product_id)
                ->increment('sales_count', $data->count);
        });

        $row = ProductsSaleStatistic::where([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'product_id' => $data->product_id,
        ])->first();
        if ($row) {
            $row->increment('order_count',$data->count);
            $row->increment('total_sales', $data->price2);
        } else {
            ProductsSaleStatistic::create([
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'order_count' => $data->count,
                'total_sales' => $data->price2,
                'product_id' => $data->product_id,
            ]);
        }
    }
}
