<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Http\Requests\UpdateEmailRequest;

class UpdateEmailController extends Controller
{
    public function __invoke(UpdateEmailRequest $request)
    {
        $seller = $request->user();
        
    }
}
