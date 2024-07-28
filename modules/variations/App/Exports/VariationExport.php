<?php

namespace Modules\variations\App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VariationExport implements FromArray, WithHeadings
{
    private $variations;

    public function __construct($variations)
    {
        $this->variations = $variations;
    }
    public function headings(): array
    {
        return [
            'محصول',
            'شناسه تنوع قیمت',
            'پارامتر اول',
            'پارامتر دوم',
            'قیمت محصول',
            'قیمت محصول فروش',
            'تعداد موجودی',
            'تعداد سفارش در هر سبد خرید',
            'زمان آماده سازی',
            'تعداد افزایش',
        ];
    }

    public function array(): array
    {
        $result = [];
        foreach ($this->variations as $variation) {
            if($variation->product != null){
                $array = [
                    $variation->product->title,
                    $variation->id,
                    $variation->param1 != null ? $variation->param1->name : '' ,
                    $variation->param2 != null ? $variation->param2->name : '' ,
                    number_format($variation->price1),
                    number_format($variation->price2),
                    number_format($variation->product_count),
                    $variation->max_product_cart,
                    $variation->preparation_time,
                    '0',
                ];
                $result[] = $array;
            }
        }
        return $result;
    }
}
