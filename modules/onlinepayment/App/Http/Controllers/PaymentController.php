<?php

namespace Modules\onlinepayment\App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\onlinepayment\App\Models\Payment;
use Modules\core\App\Http\Controllers\CrudController;

class PaymentController extends CrudController
{
    protected string $model = Payment::class;
    protected Builder $query;
    protected array $searchMethods = [
        'table_id',
        'start_date',
        'end_date'
    ];
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $this->query = Payment::query();
        $this->query->orderBy('id', 'DESC');
        foreach ($this->searchMethods as $method) {
            if(array_key_exists($method,$data) && $data[$method] != null){
                $this->$method($data);
            }
        }
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $this->query->onlyTrashed();
        }
        $trashCount = Payment::onlyTrashed()->count();
        return [
            'payments' => $this->query->paginate(env('PAGINATE')),
            'trashCount' => $trashCount
        ];
    }

    protected function table_id($data)
    {
       $this->query->where('table_id',$data['table_id']);
    }

    protected function start_date($data)
    {
       $dataArray = explode('/',$data['start_date']);
       if(sizeof($dataArray) == 3){
            $timestamp = timestamp($dataArray[0],$dataArray[1],$dataArray[2]);
            $this->query->where('created_at','>=',$timestamp);
       }
    }

    protected function end_date($data)
    {
        $dataArray = explode('/',$data['end_date']);
        if(sizeof($dataArray) == 3){
             $timestamp = timestamp($dataArray[0],$dataArray[1],$dataArray[2],23,59,59);
             $this->query->where('created_at','<=',$timestamp);
        }
    }
}
