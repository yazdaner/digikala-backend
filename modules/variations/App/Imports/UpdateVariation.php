<?php

namespace Modules\variations\App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\variations\App\Models\Variation;

class UpdateVariation implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $values = $row->values();
            $variation = Variation::where('id', $values[1])->first();
            if ($variation) {
                $data = $this->getData($variation, $values);
                if (sizeof($data) > 0) {
                    $variation->update($data);
                }
            }
        }
    }

    private function getData($variation, $values)
    {
        $result = [];
        $price1 = str_replace(',', '', $values[4]);
        $price2 = str_replace(',', '', $values[5]);
        if (intval($variation->price1) != intval($price1)) {
            $result['price1'] = $price1;
        }
        if (intval($variation->price2) != intval($price2)) {
            $result['price2'] = $price2;
        }
        if (intval($variation->preparation_time) != intval($values[8])) {
            $result['preparation_time'] = $values[8];
        }
        if (intval($variation->max_product_cart) != intval($values[7])) {
            $result['max_product_cart'] = $values[7];
        }

        if (intval($values[9]) != 0) {
            $result['product_count'] = intval($variation->product_count) + intval($values[9]);
        }
        return $result;
    }
}
