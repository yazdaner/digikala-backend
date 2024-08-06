<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Rules\ValidateMobileNumber;

class UpdateNotificationMobileController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate(
            $request,
            [
                'notification-mobile' => ['required', new ValidateMobileNumber()],
            ],
            [],
            [
                'notification-mobile' => 'شماره موبایل',
            ]
        );
        runEvent('seller:update-information', 'notification-mobile');
        return ['status' => 'ok'];
    }
}
