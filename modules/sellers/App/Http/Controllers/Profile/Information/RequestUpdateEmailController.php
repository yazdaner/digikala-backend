<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Modules\core\App\Models\VerificationCode;
use Modules\core\App\Jobs\SendVerificationCode;
use Modules\sellers\App\Http\Requests\EditEmailRequest;

class RequestUpdateEmailController extends Controller
{
    public function __invoke(EditEmailRequest $request)
    {
        $seller = $request->user();
        $encrypted = encrypt($request->get('email'));
        $code = rand(9999, 99999);
        VerificationCode::create([
            'tableable_type' => Seller::class,
            'tableable_id' => $seller->id,
            'code' => $code,
        ]);
        SendVerificationCode::dispatch(
            $request->get('email'),
            $code,
            null,
            null
        );
        return [
            'encrypted' => $encrypted,
            'status' => 'ok'
        ];
    }
}
