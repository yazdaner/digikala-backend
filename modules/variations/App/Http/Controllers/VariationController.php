<?php

namespace Modules\variations\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\variations\App\Models\Variation;
use Modules\core\App\Http\Controllers\CrudController;

class VariationController extends CrudController
{
    protected string $model = Variation::class;

    public function index($category_id)
    {
    }

    public function store($category_id, Request $request)
    {
    }
}
