<?php

namespace Modules\variations\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\variations\App\Models\SalesLock;
use Modules\variations\App\Actions\VariationsLock;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\variations\App\Http\Requests\SalesLockRequest;

class SalesLockController extends CrudController
{
    protected string $model = SalesLock::class;

    public function index()
    {
        return SalesLock::orderBy('id', 'DESC')
            ->with(['category', 'brand'])
            ->paginate(env('PAGINATE'));
    }

    public function store(SalesLockRequest $request, VariationsLock $VariationsLock)
    {
        DB::beginTransaction();
        try {
            $salesLock = new SalesLock($request->all());
            $salesLock->category_id = intval($request->get('category_id'));
            $salesLock->brand_id = intval($request->get('brand_id'));
            $salesLock->saveOrFail();
            $VariationsLock($salesLock);
            DB::commit();
            return ['status' => 'ok'];
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['status' => 'error'];
        }
    }

    public function show($id)
    {
        return SalesLock::findOrFail($id);
    }

    public function update($id,SalesLockRequest $request)
    {
        $salesLock = SalesLock::findOrFail($id);
        $salesLock->description = $request->get('description');
        $salesLock->update();
        return ['status' => 'ok'];
    }
}
