<?php

namespace Modules\filemanager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\filemanager\App\Http\Requests\FileUploadRequest;

class UploadFileController extends Controller
{
    public function __invoke(FileUploadRequest $request)
    {
        $path = fileDirectory($request->post('fileDirectory'));
        $file = $request->file('file');
        $fileName = time() . '-' . $file->getClientOriginalName();
        $request->file('file')->move($path, $fileName);
        return ['status' => 'ok', 'filename' => $fileName];
    }
}
