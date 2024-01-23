<?php

namespace Modules\products\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\products\App\Models\Product;
use Modules\products\App\Http\Actions\CreateProduct;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\products\App\Http\Requests\ProductRequest;
use Modules\products\App\Http\Actions\ProductPagination;
use Modules\products\App\Http\Actions\UpdateProduct;
use Modules\products\App\Models\ProductsDetail;

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

    public function show($id)
    {
        $product = Product::findOrFail($id)->makeVisible(['content']);
        $options = ProductsDetail::where('product_id',$id)->get();
        foreach($options as $option){
            $product->{$option->name} = $option->value;
        }
        return $product;
    }

    public function update($id,ProductRequest $request,UpdateProduct $updateProduct)
    {
        return $updateProduct($request,$id);
    }

}


