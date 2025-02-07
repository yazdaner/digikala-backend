<?php

namespace Modules\sellers\App\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\core\App\Jobs\SendVerificationCode;

class UpdateOnTimePassword
{
    public function __invoke($seller)
    {
        $code = rand(9999, 99999);
        $seller->update([
            'password' => Hash::make($code)
        ]);
        SendVerificationCode::dispatch(
            $seller->username,
            $code,
            null,
            config('seller.verify_template')
        );
    }
}
