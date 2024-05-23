<?php

namespace Modules\faq\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\faq\App\Models\FaqQuestions;

class FaqQuestionInfoController extends Controller
{
    public function __invoke($id)
    {
        return FaqQuestions::with('category')->findOrFail($id);
    }
}
