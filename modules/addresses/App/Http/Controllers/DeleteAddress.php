<?php

namespace Modules\addresses\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\addresses\App\Models\Address;


class DeleteAddress extends Controller
{
    public function __invoke(Request $request,$id)
    {
        $address = Address::where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->firstOrFail();
        $address->delete();
        return ['status' => 'ok'];
    }
}
