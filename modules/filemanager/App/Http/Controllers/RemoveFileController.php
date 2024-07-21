<?php

namespace Modules\filemanager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RemoveFileController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, ['file' => ['string', 'required']], [], ['file' => 'فایل']);
        $file = str_replace(url('/'), '', $request->post('file'));
        $fullPath = fileDirectory($file);
        if (is_dir($fullPath)) {
            rmdir($fullPath);
        } elseif (file_exists($fullPath)) {
            unlink($fullPath);
        } else {
            return ['status' => 'error', 'message' => 'فایل پیدا نشد'];
        }
        return ['status' => 'ok'];
    }
}
