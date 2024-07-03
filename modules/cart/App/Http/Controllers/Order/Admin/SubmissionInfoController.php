<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Submission;

class SubmissionInfoController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $user = $request->user();
        $submission = Submission::with([
            'items.product',
            'items.variation'
        ])->with('order',function($query){
            return $query->select(['id','address_id'])->with('address');
        });
        $submission = $submission->findOrFail($id);
        $submission->user_info = runEvent('user:info', $submission->user_id, true);
        return runEvent('completing_submission_info', $submission, true);
    }
}
