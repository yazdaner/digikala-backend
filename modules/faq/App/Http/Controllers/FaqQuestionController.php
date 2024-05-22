<?php

namespace Modules\faq\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\faq\App\Models\FaqQuestions;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\faq\App\Http\Requests\FaqQuestionRequest;

class FaqQuestionController extends CrudController
{
    protected string $model = FaqQuestions::class;

    public function index(Request $request)
    {
    }

    public function show($id)
    {
    }
    
    public function store(FaqQuestionRequest $request)
    {
    }

    public function update($id, FaqQuestionRequest $request)
    {
    }

    
}
