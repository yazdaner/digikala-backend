<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Submission;

class ChangeSubmissionStatusController extends Controller
{
    public function __invoke(Submission $submission,Request $request)
    {
        $submission->send_status = $request->status;
        $submission->update();
        runEvent('submission-change',$submission);
        Order::where('id',$submission->order_id)->update([
            'status' => $request->status
        ]);
        return ['status' => 'ok'];
    }
}
