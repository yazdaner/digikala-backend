<?php

namespace Modules\addresses\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\addresses\App\Models\Address;

class GetAddresses extends Controller
{
    public function __invoke(Request $request)
    {
        $addresses = Address::query();
        $addresses->orderBy('id','DESC')
        ->with('city')
        ->where('user_id',$request->user()->id);
        if($request->has('paginate')){
            return $addresses->paginate(env('PAGINATE '));
        }else{
            return $addresses->get();
        }
    }
}
