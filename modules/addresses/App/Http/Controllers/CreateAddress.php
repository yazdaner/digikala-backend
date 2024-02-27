<?php

namespace Modules\addresses\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\addresses\App\Http\Requests\AddressRequest;
use Modules\addresses\App\Jobs\CreateStaticMap;
use Modules\addresses\App\Models\Address;

class CreateAddress extends Controller
{
    public function __invoke(AddressRequest $request)
    {
        $address = new Address(
            $request->validated()
        );
        $address->user_id = auth()->id();
        $address->saveOrFail();
        CreateStaticMap::dispatch($address->id);
        return ['status' => 'ok'];
    }
}
