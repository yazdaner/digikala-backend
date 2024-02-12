<?php

namespace Modules\users\App\Http\Actions;

use Illuminate\Http\Request;

class AddUserSetting
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $config = config('gallery');
        $array = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                if ($request->hasFile($key)) {
                    $ex = $request->file($key)->getClientOriginalExtension();
                    if (in_array($ex, $array)) {
                        $imageUrl = upload_file($request, $key, 'images');
                        if ($imageUrl != null) {
                            $config[$key] = 'images/' . $imageUrl;
                        }
                    }
                } else {
                    $config[$key] = $value;
                }
            }
        }
        $content = '<?php return ' . var_export($config, true) . ';';
        file_put_contents(config_path('gallery.php'), $content);
    }
}
