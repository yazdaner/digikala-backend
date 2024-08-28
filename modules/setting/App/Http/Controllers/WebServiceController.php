<?php

namespace Modules\setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebServiceController extends Controller
{
    public function getValue()
    {
        return settings(['sms','gateway']);
    }

    public function setValue(Request $request)
    {
       runEvent('setting:update-create',$request->all());
       return ['status' => 'ok'];
    }
}
