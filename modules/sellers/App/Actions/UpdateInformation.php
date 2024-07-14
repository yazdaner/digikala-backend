<?php

namespace Modules\sellers\App\Actions;

use Modules\sellers\App\Models\SellerInformation;

class UpdateInformation
{
    public function __invoke(array $data, int $sellerId)
    {
        foreach ($data as $key => $value) {
            SellerInformation::updateOrCreate(
                [
                    'seller_id' => $sellerId,
                    'name' => $key,
                ],
                [
                    'value' => $value
                ]
            );
        }
    }
}
