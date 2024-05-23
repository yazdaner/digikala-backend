<?php

namespace Modules\faq\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\faq\App\Models\FaqQuestions;

class ReturnFaqQuestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $faqQuestions = FaqQuestions::query();
        if ($request->get('popular') == 'true') {
            $faqQuestions->where('popular', 1);
        }
        if ($request->has('category_id')) {
            $faqQuestions->where('category_id', $request->get('category_id'));
        }
        return $faqQuestions->get();
    }
}
