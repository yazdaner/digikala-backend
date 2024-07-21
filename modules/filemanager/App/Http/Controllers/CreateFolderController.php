<?php

namespace Modules\filemanager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateFolderController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, ['path' => ['string', 'required']], [], ['path' => 'مسیر پوشه']);
        try {

            $path = fileDirectory($request->post('path'));
            if (!is_dir($path)) {
                mkdir($path);
                return ['status' => 'ok'];
            } else {
                return ['status' => 'error', 'message' => 'پوشه از قبل وجود دارد'];
            }
        } catch (\Exception $e) {
            return ['status' => 'error'];
        }
    }
}
