<?php

namespace Modules\questions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\questions\App\Models\LikeHistory;
use Modules\questions\App\Models\Question;

class AnswerScoreController extends Controller
{
    public function __invoke($asnwer_id, Request $request)
    {
        $type = $request->get('type');
        $user = $request->user();
        $value = $type == 'like' ? 1 : 0;
        $row = LikeHistory::where([
            'question_id' => $asnwer_id,
            'user_id' => $user->id
        ])->first();
        if ($row) {
            if (intval($row->like) == $value) {
                $row->delete();
                Question::where('id', $asnwer_id)->decrement($type);
            } else {
                $row->like = $value;
                $row->update();
                Question::where('id', $asnwer_id)->decrement($value == 0 ? 'like' : 'dislike');
                Question::where('id', $asnwer_id)->increment($type);
            }
        } else {
            Question::where('id', $asnwer_id)->increment($type);
            LikeHistory::create([
                'question_id' => $asnwer_id,
                'user_id' => $user->id,
                'like' => $value
            ]);
        }
        $answer = Question::where('id', $asnwer_id)->first();
        return [
            'like' => $answer->like,
            'dislike' => $answer->dislike,
        ];
    }
}
