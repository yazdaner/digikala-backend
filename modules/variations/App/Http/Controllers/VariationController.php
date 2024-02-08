<?php

namespace Modules\variations\App\Http\Controllers;

use Modules\variations\App\Models\Variation;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\variations\App\Http\Requests\VariationRequest;

class VariationController extends CrudController
{
    protected string $model = Variation::class;


    public function index(Type $var = null)
    {
        # code...
    }

    public function store($product_id, VariationRequest $request)
    {
        runEvent('variation:add', $product_id, true);
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Variation::findtOrFial($id);
    }

    public function update($id, VariationRequest $request)
    {
        runEvent('variation:update', $id, true);
        return ['status' => 'ok'];
    }
}
