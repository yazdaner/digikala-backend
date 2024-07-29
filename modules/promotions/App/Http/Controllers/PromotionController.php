<?php

namespace Modules\promotions\App\Http\Controllers;

use Modules\promotions\App\Models\Promotion;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\promotions\App\Http\Requests\PromotionRequest;

class PromotionController extends CrudController
{
    protected string $model = Promotion::class;

    public function store(PromotionRequest $request)
    {
        $promotion = new Promotion($request->all());
        $promotion->start_time = createTimestampFromDate(
            $request->get('start_time')
        );
        $promotion->end_time = createTimestampFromDate(
            $request->get('end_time'),
            '23:59:59'
        );
        $promotion->saveOrFail();
        return ['status' => 'ok'];
    }
}
