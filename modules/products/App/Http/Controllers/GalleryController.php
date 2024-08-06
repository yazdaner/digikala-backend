<?php

namespace Modules\products\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\products\App\Models\Product;
use Modules\products\App\Http\Requests\GalleryUploadRequest;

class GalleryController extends Controller
{
    public function upload(GalleryUploadRequest $request)
    {
        return runEvent('gallery:upload', $request, true);
    }

    public function destroy(Request $request)
    {
        $path = $request->get('path');
        $gallery = runEvent('gallery:find', [
            'path' => $path,
            'tableable_type' => Product::class
        ], true);
        if ($gallery && is_object($gallery)) {
            runEvent('gallery:delete', $gallery->id);
            runEvent('gallery:remove-file', $path);
            return ['status' => 'ok'];
        }
        elseif(file_exists(fileDirectory($path))){
            runEvent('gallery:remove-file', $path);
            return ['status' => 'ok'];
        }
        else {
            return ['status' => 'error'];
        }
    }
}
