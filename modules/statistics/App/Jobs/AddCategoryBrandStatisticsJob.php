<?php

namespace Modules\statistics\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Modules\statistics\App\Models\CategoryBrandStatistics;

class AddCategoryBrandStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $items = runEvent('order:products', $this->order->id, true);

        if ($items != null && sizeof($items) > 0) {
            foreach ($items as $item) {
                $product = runEvent('product:query', function ($query) use ($item) {
                    return $query->where('id', $item->product_id)->first();
                }, true);
                if ($product) {
                    $category_id = $product->category_id;
                    $brand_id = $product->brand_id;
                    if ($category_id != null && $brand_id != null) {
                        $this->addStatistics($category_id, $brand_id, $item->count);
                    }
                }
            }
        }
    }

    private function addStatistics($category_id, $brand_id, $count): void
    {
        $row = CategoryBrandStatistics::where([
            'category_id' => $category_id,
            'brand_id' => $brand_id,
        ])->first();
        if ($row) {
            $row->increment('count', $count);
        } else {
            CategoryBrandStatistics::create([
                'category_id' => $category_id,
                'brand_id' => $brand_id,
                'count' => 1,
            ]);
        }
    }
}
