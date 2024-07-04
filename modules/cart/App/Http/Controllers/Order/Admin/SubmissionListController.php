<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Modules\cart\App\Models\Submission;

class SubmissionListController extends Controller
{
    protected Builder $query;

    protected array $searchMethods = [
        'order_id',
        'start_date',
        'end_date',
        'status'
    ];

    public function __invoke(Request $request)
    {
        $data = $request->all();
        $this->query = Submission::query();
        $this->query->with('items')->orderBy('id', 'DESC');

        foreach ($this->searchMethods as $method) {
            $this->$method($data);
        }

        return $this->query->paginate(env('PAGINATE'));
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

    protected function status($data)
    {
        if (array_key_exists('status', $data) && $data['status'] != null) {
            $this->query->where('status', $data['status']);
        }
    }
}
