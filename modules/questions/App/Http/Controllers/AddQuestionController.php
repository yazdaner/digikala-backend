<?php

namespace Modules\questions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\questions\App\Http\Requests\QuestionRequest;
use Modules\questions\App\Models\Question;

class AddQuestionController extends Controller
{
    public function __invoke(QuestionRequest $request)
    {
        $user = $request->user();
        $question = new Question($request->all());
        $question->user_type = $user::class;
        $question->user_id = $user->id;
        if($user->role == 'admin'){
            $question->status = 1;
        }
        $question->saveOrFail();
        return ['status' => 'ok'];
    }
}
