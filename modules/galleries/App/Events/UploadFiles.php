<?php

namespace Modules\galleries\App\Events;

use Illuminate\Http\Request;

class UploadFiles
{
    public function handle(Request $request)
    {
        $paths = [];
        $files = $request->all()['files'];
        $array = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        foreach ($files as $key => $image) {
            if (method_exists($image, 'getClientOriginalExtension')) {
                $ex = $image->getClientOriginalExtension();
                if (in_array($ex, $array)) {
                    $fileName = $key . time() . '.' . $ex;
                    if ($image->move('public/gallery', $fileName)) {
                        $paths[] = 'public/gallery/' . $fileName;
                    }
                }
            }
        }
        return ['status' => 'ok', 'paths' => $paths];
    }
}
