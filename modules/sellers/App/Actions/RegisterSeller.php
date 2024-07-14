<?php

namespace Modules\sellers\App\Actions;

use Illuminate\Http\Request;
use Modules\core\App\Jobs\SendVerificationCode;
use Modules\sellers\App\Models\Seller;
use Modules\core\App\Models\VerificationCode;

class RegisterSeller
{
    public function __invoke(Request $request)
    {
        $username = $request->get('username');
        $seller = Seller::where('username', $username)
            ->where('status', '<', -1)
            ->forceDelete();
        $code = rand(9999, 99999);
        $seller = Seller::create([
            'status' => -3,
            'username' => $username,
        ]);
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
        );
    }
}
