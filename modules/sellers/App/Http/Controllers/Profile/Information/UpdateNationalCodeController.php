<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Http\Requests\UpdateNationalCodeRequest;

class UpdateNationalCodeController extends Controller
{
    public function __invoke(UpdateNationalCodeRequest $request)
    {
        runEvent('seller:update-information', 'nationalCode');
        return ['status' => 'ok'];
    }
}
