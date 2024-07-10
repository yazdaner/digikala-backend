<?php

namespace Modules\blogs\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\blogs\App\Http\Requests\CategoryRequest;
use Modules\blogs\App\Models\BlogCategory;
use Modules\core\App\Http\Controllers\CrudController;

class BlogCategoryController extends CrudController
{
    protected string $model = BlogCategory::class;

    public function index(Request $request): array
    {
        $categories = BlogCategory::search($request->all());
        return [
            'categories' => $categories,
            'trashCount' => BlogCategory::onlyTrashed()->count()
        ];
    }

    public function store(CategoryRequest $request): array
    {
        $category = new BlogCategory($request->all());
        $category->slug = replaceSpace($request->get('en_name'));
        $category->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return BlogCategory::findOrFail($id);
    }

    public function update($id, CategoryRequest $request): array
    {
        $category = BlogCategory::findOrFail($id);
        $category->slug = replaceSpace($request->get('en_name'));
        $category->update($request->all());
        return ['status' => 'ok'];
    }

    public function all()
    {
        return BlogCategory::get();
    }
}
