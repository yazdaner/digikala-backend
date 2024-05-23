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
    public function index(Request $request): array
    {
        $faqCategories = FaqCategories::search($request->all());
        return [
            'faqCategories' => $faqCategories,
            'trashCount' => FaqCategories::onlyTrashed()->count(),
        ];
    }

    public function store(FaqCategoryRequest $request)
    {
        $faqCategory = new FaqCategories($request->all());
        $imgUrl = upload_file($request, 'icon', 'upload');
        if ($imgUrl) {
            $faqCategory->icon = $imgUrl;
        }
        $faqCategory->saveOrFail();
        return ['status' => 'ok'];
    }

    public function update($id, FaqCategoryRequest $request)
    {
        $data = $request->all();
        $faqCategory = FaqCategories::findOrFail($id);
        $imgUrl = upload_file($request, 'icon', 'upload');
        if ($imgUrl) {
            $faqCategory->icon = $imgUrl;
        }
        unset($data['icon']);
        $faqCategory->update($data);
        return ['status' => 'ok'];
    }

    // front
    public function all()
    {
        return FaqCategories::select(['id', 'name', 'icon'])->get();
    }

    public function show($id)
    {
        return FaqCategories::findOrFail($id);
    }
}
