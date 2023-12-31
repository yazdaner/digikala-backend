<?php

use Illuminate\Support\Facades\App;

function modulesList()
{
    $path = base_path('modules');
    $modules = scandir($path);
    $modules = array_diff($modules,['.','..']);
    config()->set('app.modules',$modules);
    return $modules;
}


function addModulesProviders()
{
    $modules = modulesList();
    foreach($modules as $module)
    {
        $providersDir = base_path('modules/'.$module.'/App/Providers');
        if(is_dir($providersDir))
        {
            $files = scandir($providersDir);
            $files = array_diff($files,['.','..']);
            foreach($files as $file)
            {
                $className = str_replace('.php','',$file);
                $class = '\\Modules\\'.$module.'\\App\\Providers\\'.$className;
                if(class_exists($class) && $class != '\Modules\core\App\Providers\ModuleRouteServiceProvider' )
                {
                    App::register($class);
                }
            }

        }
    }

}


function upload_file($request,$name,$dir,$pix='')
{
    if($request->hasFile($name)){
        $fileName = $pix.time().'.'.$request->file($name)->getClientOriginalExtension();
        if($request->file($name)->move('public/'.$dir,$fileName)){
            return $fileName;
        }
    }
    return null;
}



