<?php

namespace Modules\categories\App\Events;

use Illuminate\Support\Facades\DB;

class ProductSpecifications
{
    protected array $specifications = [];
    protected object $productSpecifications;

    public function handle($id)
    {
        $result = [];
        $this->productSpecifications = DB::table('products__specifications')
            ->where('product_id', $id)
            ->get();

        $characteristicIdArray = [];
        foreach ($this->productSpecifications as $item) {
            $characteristicIdArray[$item->characteristic_id] = $item->characteristic_id;
            if (intval($item->value) == $item->value) {
                $characteristicIdArray[$item->value] = $item->value;
            }
        }
        $specifications = DB::table('specifications')
            ->whereIn('id', $characteristicIdArray)
            ->orderBy('position', 'ASC')
            ->get()
            ->keyBy('id')
            ->toArray();

        foreach ($specifications as $specification) {
            if ($specification->parent_id == 0) {
                $result[$specification->id] = [
                    'key' => $specification->name,
                    'position' => $specification->position,
                    'important' => $specification->important,
                    'values' => $this->specificationsValues(
                        $specification
                    )
                ];
            }
        }
    }

    protected function specificationsValues($specification)
    {
        $result = [];
        foreach ($this->productSpecifications as $item) {
            if ($item->characteristic_id == $specification->id) {
                if (is_numeric($item->value) && array_key_exists($item->value, $this->specifications)) {
                    $result[] = $this->specifications[$item->value]->name;
                } else {
                    $result[] = $item->value;
                }
            }
        }
        return $result;
    }
}
