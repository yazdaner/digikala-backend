<?php

namespace Modules\setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminShopController extends Controller
{
    public function __invoke(Request $request)
    {
        $config = config('shop-info');
        if ($request->hasFile('icon')) {
            $this->validate(
                $request,
                ['icon' => ['image', 'max:1024']],
                [],
                ['icon' => 'لوگو فروشگاه']
            );
        }
        $data = $request->all();
        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $imageName = upload_file($request, $key, 'images');
                if ($imageName) {
                    $config[$key] = $imageName;
                }
            } else {
                $config[$key] = $value;
            }
        }
        $text = '<?php return ' . var_export($config, true) . ';';
        file_put_contents(config_path('shop-info.php'), $text);
        return ['status' => 'ok'];
    }
}
