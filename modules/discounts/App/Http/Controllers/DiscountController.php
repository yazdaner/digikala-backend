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
        $discount = new Discount($request->all());
        $discount->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Discount::findOrFail($id);
    }

    public function update($id,DiscountRequest $request)
    {
        $data = $request->all();
        $discount = Discount::findOrFail($id);
        $discount->update($data);
        return ['status' => 'ok'];
    }

    public function all()
    {
        return Discount::select(['id','name'])->get();
    }
}


