<?php

namespace Modules\galleries\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\galleries\App\Http\Actions\AddGallerySetting;

class GallerySettingController extends Controller
{
    public function __invoke(Request $request, AddGallerySetting $addGallerySetting)
    {
        if ($request->isMethod('post')) {
            $addGallerySetting($request);
            return ['status' => 'ok'];
        } else {
            return config('gallery');
        }
    }
}
