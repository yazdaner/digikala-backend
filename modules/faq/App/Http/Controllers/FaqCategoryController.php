<?php

namespace Modules\faq\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\faq\App\Models\FaqCategories;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\faq\App\Http\Requests\FaqCategoryRequest;

class FaqCategoryController extends CrudController
{
    protected string $model = FaqCategories::class;

    // admin
    public function index(Request $request)
    {
    }

    public function store(FaqCategoryRequest $request)
    {
    }

    public function update($id,FaqCategoryRequest $request)
    {
    }

    // front
    public function all()
    {
    }
    
    public function show($id)
    {
    }
}
