<?php

namespace Modules\questions\App\Http\Controllers;

use Modules\core\App\Http\Controllers\CrudController;
use Modules\questions\App\Models\Question;

class QuestionController extends CrudController
{
    protected string $model = Question::class;

    public function index()
    {
    }

    public function delete()
    {
    }
}
