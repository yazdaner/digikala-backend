<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Modules\sellers\App\Actions\AddAddress;
use Modules\sellers\App\Http\Requests\RegisterFinalStepRequest;

class RegisterFinalStepController extends Controller
{
    public function __invoke(RegisterFinalStepRequest $request, AddAddress $addAddress)
    {
        $seller = Seller::where([
            'username' => $request->get('username'),
            'status' => -1
        ])->firstOrFail();
        $addAddress($seller, $request);
        return ['status' => 'ok'];
    }
}
