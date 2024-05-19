<?php

namespace Modules\questions\App\Http\Controllers;

use Modules\core\App\Http\Controllers\CrudController;
use Modules\questions\App\Models\Question;

class QuestionController extends CrudController
{
    protected string $model = Question::class;

    public function __invoke()
    {
        $questions = Question::query();
        $questions->orderBy('id','DESC');
        $questions->with('parent');
        $questions->with('user',function($query){
            return $query->select(['name','id']);
        });
        $questions->with('product',function($query){
            return $query->select(['title','id','slug']);
        });
        return $questions->paginate(env('PAGINATE'));
    }
}
