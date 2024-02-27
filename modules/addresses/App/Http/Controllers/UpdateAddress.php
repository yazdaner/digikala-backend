<?php

namespace Modules\addresses\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\addresses\App\Jobs\CreateStaticMap;
use Modules\addresses\App\Models\Address;

class UpdateAddress extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $user = $request->user();
        $address = Address::where([
            'id' => $id,
            'user_id' => $user->id
        ])->firstOrFail();
        $address->update($request->validated());
        if (
            $address->longitude != $request->longitude ||
            $address->latitude != $request->latitude
        ) {
            CreateStaticMap::dispatch($address->id);
        }
        return ['status' => 'ok'];
    }
}
