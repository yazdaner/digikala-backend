<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Modules\core\App\Models\VerificationCode;
use Modules\core\App\Jobs\SendVerificationCode;

class SendVerificationCodeContoller extends Controller
{
    public function __invoke(Request $request)
    {
        $username = $request->post('username');
        $seller = Seller::where(['username' => $username])
            ->where('status', '>=', -1)->firstOrFail();
        $code = rand(10000, 99999);
        VerificationCode::create([
            'tableable_type' => Seller::class,
            'tableable_id' => $seller->id,
            'code' => $code
        ]);
        SendVerificationCode::dispatch(
            $username,
            $code,
            null,
            config('seller.verify_template')
        )->onConnection('database');
        return ['status' => 'ok'];
    }
}
