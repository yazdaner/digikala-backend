<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyInfoController extends Controller
{
    public function __invoke(Request $request)
    {
      $config = config('company');
       if($request->method() == 'POST'){
            $data = $request->all();
            foreach ($data as $key => $value) {
                if(!empty($value)){
                    $config[$key] = $value;
                }
            }
            $text ='<?php return '.var_export($config,true).';';
            file_put_contents(config_path('company.php'),$text);
        return ['status' => 'ok'];
       }else{
            return $config;
       }
    }
}
