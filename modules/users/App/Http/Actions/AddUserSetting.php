<?php

namespace Modules\users\App\Http\Actions;

use Illuminate\Http\Request;

class AddUserSetting
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $config = config('users');
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $config[$key] = $value;
            }
        }
        $content = '<?php return ' . var_export($config, true) . ';';
        file_put_contents(config_path('users.php'), $content);
    }
}
