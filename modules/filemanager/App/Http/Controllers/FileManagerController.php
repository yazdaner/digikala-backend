<?php

namespace Modules\filemanager\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, ['path' => ['string', 'required']], [], ['path' => 'مسیر پوشه']);
        $path = fileDirectory($request->get('path'));
        return array_diff(scandir($path),['.','..']);
    }
}
