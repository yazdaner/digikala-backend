<?php

namespace Modules\discounts\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\discounts\App\Models\Discount;
use Modules\discounts\App\Http\Requests\DiscountRequest;
use Modules\core\App\Http\Controllers\CrudController;

class DiscountController extends CrudController
{

    protected string $model = Discount::class;

    public function index(Request $request)
    {
        $discounts = Discount::search($request->all());
        return [
            'discounts' => $discounts,
            'trashCount' => Discount::onlyTrashed()->count(),
        ];
    }

    public function store(DiscountRequest $request)
    {
        $discount = new Discount($request->validated());
        $dataArray = explode('/',$request->post('expiration_date'));
        $discount->expiration_date = timestamp($dataArray[0],$dataArray[1],$dataArray[2],23,59,59);
        $discount->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show(Discount $discount)
    {
        return $discount;
    }

    public function update(Discount $discount,DiscountRequest $request)
    {
        $data = $request->all();
        $dataArray = explode('/',$request->post('expiration_date'));
        $discount->expiration_date = timestamp($dataArray[0],$dataArray[1],$dataArray[2],23,59,59);
        unset($data['expiration_date']);
        $discount->update($data);
        return ['status' => 'ok'];
    }

    public function all()
    {
        return Discount::select(['id','name'])->get();
    }
}


