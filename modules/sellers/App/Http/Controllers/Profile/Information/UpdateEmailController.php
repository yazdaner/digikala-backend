<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Modules\sellers\App\Http\Requests\UpdateEmailRequest;

class UpdateEmailController extends Controller
{
    public function __invoke(UpdateEmailRequest $request)
    {
        $encrypted = $request->get('encrypted');
        $decrypt = decrypt($encrypted);
        if(!empty($decrypt)){
            $seller = $request->user();
            $seller->email = $decrypt;
            $seller->update();
            return ['status' => 'ok'];
        }else{
            throw ValidationException::withMessages([
                'encrypted' => 'اطلاعات ارسال معتبر نمی باشد'
            ]);
        }
    }
}
