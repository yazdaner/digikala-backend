<?php

use Modules\core\Lib\Jdf;
use Illuminate\Support\Facades\App;
use Intervention\Image\ImageManager;

function modulesList()
{
    $path = base_path('modules');
    $modules = scandir($path);
    $modules = array_diff($modules, ['.', '..']);
    config()->set('app.modules', $modules);
    return $modules;
}

function addModulesProviders()
{
    $modules = modulesList();
    foreach ($modules as $module) {
        $providersDir = base_path('modules/' . $module . '/App/Providers');
        if (is_dir($providersDir)) {
            $files = scandir($providersDir);
            $files = array_diff($files, ['.', '..']);
            foreach ($files as $file) {
                $className = str_replace('.php', '', $file);
                $class = '\\Modules\\' . $module . '\\App\\Providers\\' . $className;
                if (class_exists($class) && $class != '\Modules\core\App\Providers\ModuleRouteServiceProvider') {
                    App::register($class);
                }
            }
        }
    }
}

function upload_file($request, $name, $dir, $pix = '')
{
    if ($request->hasFile($name)) {
        $fileName = $pix . time() . '.' . $request->file($name)->getClientOriginalExtension();
        if ($request->file($name)->move(fileDirectory($dir), $fileName)) {
            return $fileName;
        }
    }
    return null;
}

function replaceSpace($string)
{
    $string = str_replace('-', ' ', $string);
    return preg_replace('/\s+/', '-', $string);
}

function addEvent($name, $object)
{
    $events = config('app.events');
    if (array_key_exists($name, $events)) {
        $add = false;
        foreach ($events[$name] as $event) {
            if ($event !== $object) {
                $add = true;
            }
        }
        if ($add) {
            $events[$name][] = $object;
        }
    } else {
        $events[$name][] = $object;
    }
    config()->set('app.events', $events);
}

function runEvent($name, $data, $return = false)
{
    $events = config('app.events');
    if (array_key_exists($name, $events)) {
        foreach ($events[$name] as $event) {
            if ($event != null) {
                $object = new $event;
                if ($return) {
                    $result = $object->handle($data);
                    if ($result !== null) {
                        $data = $result;
                    }
                } else {
                    $object->handle($data);
                }
            }
        }
    }

    if ($return) {
        return $data;
    }
}

function timestamp($y, $n, $d, $h = 0, $m = 0, $s = 0)
{
    return Jdf::jmktime(
        Jdf::tr_num($h),
        Jdf::tr_num($m),
        Jdf::tr_num($s),
        Jdf::tr_num($n),
        Jdf::tr_num($d),
        Jdf::tr_num($y)
    );
}

function createTimestampFromDate($date, $time = '0:0:0')
{
    $dateArray = explode('/', $date);
    $timeArray = explode(':', $time);
    if (sizeof($dateArray) == 3 && sizeof($timeArray) == 3) {
        return timestamp(
            $dateArray[0],
            $dateArray[1],
            $dateArray[2],
            $timeArray[0],
            $timeArray[1],
            $timeArray[2],
        );
    } else {
        return 0;
    }
}

function create_fit_pic($path, $fileName, $width = 350, $height = 350)
{
    if ($fileName != null) {
        $image = ImageManager::imagick()->read(fileDirectory($path));
        $image->resize($width, $height);
        $image->save(fileDirectory('thumbnails/' . $fileName));
    }
}

function fileDirectory($path = '')
{
    return base_path('public/' . $path);
}

function addArrayList($name, $array)
{
    if (config()->has('app.' . $name)) {
        $default = config()->get('app.' . $name);
        $default[] = $array;
        config()->set('app.' . $name, $default);
    } else {
        config()->set('app.' . $name, [$array]);
    }
}

function replaceFaNumber($number)
{
    $number = str_replace('٠', '0', $number);
    $number = str_replace('١', '1', $number);
    $number = str_replace('٢', '2', $number);
    $number = str_replace('٣', '3', $number);
    $number = str_replace('٤', '4', $number);
    $number = str_replace('٥', '5', $number);
    $number = str_replace('٦', '6', $number);
    $number = str_replace('٧', '7', $number);
    $number = str_replace('٨', '8', $number);
    $number = str_replace('٩', '9', $number);
    return $number;
}
