<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\sellers\App\Models\Seller;
use Modules\core\App\Models\VerificationCode;
use Modules\core\App\Jobs\SendVerificationCode;

class SendVerificationCodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $result = ['status' => 'error'];
        $username = $request->post('username');
        $seller = Seller::where(['username' => $username])->first();
        if ($seller) {
            $code = rand(10000, 99999);
            if ($seller->status >= -1) {
                $seller->update([
                    'password' => Hash::make($code)
                ]);
            } else {
                VerificationCode::create([
                    'tableable_type' => Seller::class,
                    'tableable_id' => $seller->id,
                    'code' => $code
                ]);
            }
            SendVerificationCode::dispatch(
                $username,
                $code,
                null,
                config('seller.verify_template')
            )->onConnection('database');
            $result = ['status' => 'ok'];
        }
        return $result;
    }
}
