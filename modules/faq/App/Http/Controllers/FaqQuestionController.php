<?php

namespace Modules\faq\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\faq\App\Models\FaqQuestions;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\faq\App\Http\Requests\FaqQuestionRequest;

class FaqQuestionController extends CrudController
{
    protected string $model = FaqQuestions::class;

    public function index(Request $request): array
    {
        $faqQuestions = FaqQuestions::search($request->all());
        return [
            'faqQuestions' => $faqQuestions,
            'trashCount' => FaqQuestions::onlyTrashed()->count(),
        ];
    }

    public function show($id)
    {
        return FaqQuestions::findOrFail($id);
    }

    public function store(FaqQuestionRequest $request)
    {
        $popular = $request->get('popular') == 'true' ? 1 : 0;
        $faqQuestions = new FaqQuestions($request->all());
        $faqQuestions->popular = $popular;
        $faqQuestions->saveOrFail();
        return ['status' => 'ok'];
    }

    public function update($id, FaqQuestionRequest $request)
    {
        $data = $request->all();
        $popular = $request->get('popular') == 'true' ? 1 : 0;
        $data['popular'] = $popular;
        $faqCategory = FaqQuestions::findOrFail($id);
        $faqCategory->update($data);
        return ['status' => 'ok'];
    }
}
