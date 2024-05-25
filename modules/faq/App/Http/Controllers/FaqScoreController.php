<?php

namespace Modules\faq\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\faq\App\Models\FaqQuestions;
use Modules\faq\App\Models\FaqLikeHistory;

class FaqScoreController extends Controller
{
    public function __invoke($faq, Request $request)
    {
        $type = $request->get('type');
        $user = $request->user();
        $value = $type == 'like' ? 1 : 0;
        $row = FaqLikeHistory::where([
            'faq_id' => $faq,
            'user_id' => $user->id
        ])->first();
        if ($row) {
            if (intval($row->like) == $value) {
                $row->delete();
                FaqQuestions::where('id', $faq)->decrement($type);
            } else {
                $row->like = $value;
                $row->update();
                FaqQuestions::where('id', $faq)->decrement($value == 0 ? 'like' : 'dislike');
                FaqQuestions::where('id', $faq)->increment($type);
            }
        } else {
            FaqQuestions::where('id', $faq)->increment($type);
            FaqLikeHistory::create([
                'faq_id' => $faq,
                'user_id' => $user->id,
                'user_type' => $user::class,
                'like' => $value
            ]);
        }
        $faq = FaqQuestions::where('id', $faq)->first();
        return [
            'like' => $faq->like,
            'dislike' => $faq->dislike,
        ];
    }
}
