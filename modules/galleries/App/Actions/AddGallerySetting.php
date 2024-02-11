<?php

namespace Modules\galleries\App\Http\Actions;

use Illuminate\Http\Request;

class AddGallerySetting
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $config = config('gallery');
        $array = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];

        $content = '<?php return ' . var_export($config, true) . ';';
        file_put_contents(config_path('gallery.php'),$content);
    }
}
