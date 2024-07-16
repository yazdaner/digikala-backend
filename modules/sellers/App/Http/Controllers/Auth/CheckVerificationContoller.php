<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use Modules\core\App\Models\VerificationCode;

class CheckVerificationContoller extends Controller
{
    public function __invoke(Request $request)
    {
        $username = $request->get('username');
        $code = $request->get('code');
        $type = $request->get('type');
        $seller = Seller::where('username', $username)->firstOrFail();
        $verification = VerificationCode::where([
            'tableable_type' => Seller::class,
            'tableable_id' => $seller->id,
            'code' => $code
        ])->first();
        if ($verification) {
            $verification->delete();
            if ($type == 'forget-password') {
                $token = $this->broker()->sendResetLink(
                    $request->only('username')
                );
                return ['status' => 'ok', 'token' => $token];
            } else {
                $seller->status = -2;
                if (filter_var($seller->username, FILTER_VALIDATE_EMAIL)) {
                    $seller->email = $seller->username;
                } else {
                    $seller->mobile = $seller->username;
                }
                $seller->update();
                return ['status' => 'ok'];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'کد تایید وارد شده اشتباه می باشد',
            ];
        }
    }

    protected function broker(): PasswordBroker
    {
        return Password::broker(
            config('fortify.passwords')
        );
    }
}
