<?php

namespace Modules\products\App\Http\Controllers;

use Modules\products\App\Models\Product;
use Modules\products\App\Http\Requests\ProductRequest;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\products\App\Http\Actions\CreateProduct;

class ProductController extends CrudController
{

    protected $model = Product::class;

    public function store(ProductRequest $request,CreateProduct $createProduct)
    {
        return $createProduct($request);
    }

}


