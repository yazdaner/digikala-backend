<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Http\Requests\UpdateNameRequest;

class UpdateNameController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
            ],
            [],
            [
                'first_name' => 'نام',
                'last_name' => 'نام خانوادگی',
            ]
        );
        runEvent('seller:update-information', 'first_name');
        runEvent('seller:update-information', 'last_name');
        return ['status' => 'ok'];
    }
}
