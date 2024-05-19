<?php

namespace Modules\questions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\questions\App\Models\Question;

class ProductQuestionController extends Controller
{
    public function __invoke($product_id)
    {
        $questions = Question::where([
            'parent_id' => 0,
            'product_id' => $product_id,
            'status' => 1,
        ]);
        $questions = $questions->with('answers')
            ->with('user', function ($query) {
                return $query->select(['name', 'id']);
            })
            ->with('answers.user', function ($query) {
                return $query->select(['name', 'id']);
            });
        if (Auth::check()) {
            $questions = $questions->with('answers.user_like', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            });
        }
        $questions = $questions->orderBy('id', 'DESC');
        return $questions->paginate(env('PAGINATE'));
    }
}
