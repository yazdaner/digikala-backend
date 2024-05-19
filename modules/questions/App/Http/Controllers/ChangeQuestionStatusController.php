<?php

namespace Modules\questions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\questions\App\Models\Question;

class ChangeQuestionStatusController extends Controller
{
    public function __invoke(Question $question)
    {
        $question->status = ($question->status == 1) ? 0 : 1;
        $question->update();
        return ['status' => 'ok'];
    }
}
