<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use Modules\core\App\Models\VerificationCode;

class CheckVerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $username = $request->get('username');
        $code = $request->get('code');
        $seller = Seller::where('username', $username)
            ->first();
        if ($seller) {
            $verification = VerificationCode::where([
                'tableable_type' => Seller::class,
                'tableable_id' => $seller->id,
                'code' => $code
            ])->first();
            if ($verification) {
                $verification->delete();
                $seller->status = -2;
                if (filter_var($seller->username, FILTER_VALIDATE_EMAIL)) {
                    $seller->email = $seller->username;
                } else {
                    $seller->mobile = $seller->username;
                }
                $seller->update();
                return ['status' => 'ok'];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'کد وارد شده اشتباه است'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'فروشنده یافت نشد'
            ];
        }
    }
}
