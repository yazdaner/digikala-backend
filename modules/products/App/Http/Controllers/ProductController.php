<?php

namespace Modules\products\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\products\App\Models\Product;
use Modules\products\App\Http\Actions\CreateProduct;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\products\App\Http\Requests\ProductRequest;
use Modules\products\App\Http\Actions\ProductPagination;

class ProductController extends CrudController
{

    protected $model = Product::class;

    public function index(Request $request,ProductPagination $productPagination)
    {
        $products = $productPagination($request);
        return [
            'products' => $products,
            'trashCount' => Product::onlyTrashed()->count()
        ];
    }

    public function store(ProductRequest $request,CreateProduct $createProduct)
    {
        return $createProduct($request);
    }

}


