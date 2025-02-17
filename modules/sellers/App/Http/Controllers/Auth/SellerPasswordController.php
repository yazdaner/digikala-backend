<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\sellers\App\Models\Seller;

class SellerPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'max:200'],
        ]);
        $username = $request->get('username');
        $password = $request->get('password');
        $seller = Seller::where([
            'username' => $username,
            'status' => -2,
        ])->firstOrFail();
        $seller->password = Hash::make($password);
        $seller->update();
        return ['status' => 'ok'];
    }
}
