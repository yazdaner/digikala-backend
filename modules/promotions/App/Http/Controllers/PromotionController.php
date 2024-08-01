<?php

namespace Modules\promotions\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\promotions\App\Models\Promotion;
use Modules\promotions\App\Actions\SearchPromotions;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\promotions\App\Http\Requests\PromotionRequest;

class PromotionController extends CrudController
{
    protected string $model = Promotion::class;

    public function index(Request $request, SearchPromotions $SearchPromotions): array
    {
        $promotions = $SearchPromotions($request);
        return [
            'promotions' => $promotions,
            'trashCount' => Promotion::onlyTrashed()
        ];
    }

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

    public function update($id, PromotionRequest $request)
    {
        $promotion = Promotion::findOrFail($id);
        $data = $request->all();
        $promotion->start_time = createTimestampFromDate(
            $request->get('start_time')
        );
        $promotion->end_time = createTimestampFromDate(
            $request->get('end_time'),
            '23:59:59'
        );
        unset($data['start_time']);
        unset($data['end_time']);
        $promotion->update($data);
        return ['status' => 'ok'];
    }

    public function info($id)
    {
        $promotion = Promotion::with(['category','products'])->findOrFail($id);
        if(sizeof($promotion->products) > 0){
            $variationsId = [];
            foreach ($promotion->products as $product) {
                $variationsId[]= $product->variation_id;
            }
            $promotion->variations = runEvent('variation:query',function ($query) use ($variationsId){
                return $query->whereIn('id',$variationsId)
                    ->with(['product','param1','param2'])
                    ->get();
            },true); 
        }
        return $promotion;
    }
}
