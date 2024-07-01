<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use Modules\core\App\Http\Controllers\CrudController;

class OrderListController extends CrudController
{
    protected string $model = Order::class;

    protected Builder $query;

    protected array $searchMethods = [
        'user_id',
        'order_id',
        'start_date',
        'end_date'
    ];

    public function __invoke(Request $request)
    {
        $data = $request->all();
        $this->query = Order::query();
        $this->query->orderBy('id', 'DESC')->withCount('submissions');

        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $this->query->onlyTrashed();
        }


        foreach ($this->searchMethods as $method) {
            $this->$method($data);
        }

        $trashCount = Order::onlyTrashed()->count();

        return [
            'orders' => $this->query->paginate(env('PAGINATE')),
            'trashCount' => $trashCount
        ];
    }

    protected function user_id($data)
    {
        if (array_key_exists('user_id', $data) && $data['user_id'] != null) {
            $this->query->where('user_id', $data['user_id']);
        }
    }

    protected function order_id($data)
    {
        if (array_key_exists('order_id', $data) && $data['order_id'] != null) {
            $this->query->where('order_id', $data['order_id']);
        }
    }

    protected function start_date($data)
    {
        if (array_key_exists('start_date', $data) && $data['start_date'] != null) {
            $dataArr = explode('/',$data['start_date']);
            if(sizeof($dataArr) == 3){
                $timestamp = timestamp($dataArr[0],$dataArr[1],$dataArr[2]);
                $this->query->where('created_at','>=', $timestamp);
            }
        }
    }

    protected function end_date($data)
    {
        if (array_key_exists('end_date', $data) && $data['end_date'] != null) {
            $dataArr = explode('/',$data['end_date']);
            if(sizeof($dataArr) == 3){
                $timestamp = timestamp($dataArr[0],$dataArr[1],$dataArr[2],23,59,59);
                $this->query->where('created_at','<=', $timestamp);
            }
        }
    }
}
