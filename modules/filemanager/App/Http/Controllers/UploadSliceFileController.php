<?php

namespace Modules\filemanager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\filemanager\App\Http\Requests\FileUploadRequest;

class UploadSliceFileController extends Controller
{
    public function __invoke(FileUploadRequest $request)
    {
        $fileDirectory = fileDirectory($request->post('fileDirectory'));
        $file = $request->file('file');
        $part = $request->post('part');
        $append = true;
        $fileName = time() . '-' . $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
        $lasted = $request->get('lasted'); 
        $path = Storage::disk('public')
            ->path('chunks/'.$file->getClientOriginalName());
        if($part > 0){
            $oldFileSize = filesize($path);
            if($oldFileSize > ($part * 500000)){
                $append = false;
            }
        }
        if($append){
            File::append($path,$file->get());
        }
        if($lasted == 'true'){
            File::move($path,$fileDirectory.'/'.$fileName);
        }
        return ['status' => 'ok'];        
    }
}
