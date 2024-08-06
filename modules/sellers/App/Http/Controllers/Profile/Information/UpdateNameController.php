<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Http\Requests\UpdateNameRequest;

class UpdateNameController extends Controller
{
    public function __invoke(UpdateNameRequest $request)
    {
        runEvent('seller:update-information', 'first_name');
        runEvent('seller:update-information', 'last_name');
        return ['status' => 'ok'];
    }
}
