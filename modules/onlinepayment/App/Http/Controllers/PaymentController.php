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
        $this->query->orderBy('id','DESC');
        foreach ($this->searchMethods as $method) {
            $this->$method($data);
        }
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $this->query->onlyTrashed();
        }
        $trashCount = Payment::onlyTrashed()->count();
        return [
            'payments' => $this->query->paginate(env('PAGINATE')),
            'trashCount' => $trashCount
        ];
    }
}
