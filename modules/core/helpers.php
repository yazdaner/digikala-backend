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
    $string = str_replace(' ', '-', $string);
    $string = str_replace('/', '-', $string);
    $string = str_replace('\\', '-', $string);
    $string = str_replace('!', '-', $string);
    $string = str_replace('#', '-', $string);
    $string = str_replace('$', '-', $string);
    $string = str_replace('%', '-', $string);
    $string = str_replace('^', '-', $string);
    $string = str_replace('&', '-', $string);
    $string = str_replace('*', '-', $string);
    $string = str_replace('(', '-', $string);
    $string = str_replace(')', '-', $string);
    $string = str_replace('_', '-', $string);
    $string = str_replace('+', '-', $string);
    $string = str_replace('=', '-', $string);
    $string = str_replace('.', '-', $string);
    $string = str_replace(',', '-', $string);
    $string = str_replace('?', '-', $string);
    $string = str_replace('<', '-', $string);
    $string = str_replace('>', '-', $string);
    $string = str_replace('`', '-', $string);
    $string = str_replace('~', '-', $string);
    $string = str_replace('--', '-', $string);
    $string = str_replace('---', '-', $string);
    $string = str_replace('----', '-', $string);
    $string = str_replace('-----', '-', $string);
    $string = str_replace('------', '-', $string);
    $string = str_replace('-------', '-', $string);
    $string = str_replace('-------', '-', $string);
    $string = str_replace('---------', '-', $string);
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

// function create_fit_pic($path, $fileName, $width = 350, $height = 350)
// {
//     if ($fileName != null) {
//         $image = ImageManager::imagick()->read(fileDirectory($path));
//         $image->resize($width, $height);
//         $image->save(fileDirectory('thumbnails/' . $fileName));
//     }
// }

function create_fit_pic($path, $fileName, $width = 350, $height = 350)
{
    if ($fileName === null) {
        return false; // Return early if fileName is null
    }

    // Ensure the thumbnails directory exists
    $thumbnailDir = fileDirectory('thumbnails');
    if (!is_dir($thumbnailDir)) {
        mkdir($thumbnailDir, 0755, true); // Create the directory if it doesn't exist
    }

    // Get the full path to the source image
    $sourcePath = fileDirectory($path);

    // Get the image type and create an image resource
    $imageInfo = getimagesize($sourcePath);
    if ($imageInfo === false) {
        error_log("Unsupported image type or file not found: " . $sourcePath);
        return false;
    }

    $imageType = $imageInfo[2]; // Get the image type (IMAGETYPE_JPEG, IMAGETYPE_PNG, etc.)

    // Create an image resource based on the image type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            error_log("Unsupported image type: " . $imageType);
            return false;
    }

    if ($sourceImage === false) {
        error_log("Failed to create image resource: " . $sourcePath);
        return false;
    }

    // Get the original dimensions of the image
    $originalWidth = imagesx($sourceImage);
    $originalHeight = imagesy($sourceImage);

    // Calculate the aspect ratio
    $aspectRatio = $originalWidth / $originalHeight;

    // Calculate new dimensions while maintaining the aspect ratio
    if ($width / $height > $aspectRatio) {
        $newWidth = $height * $aspectRatio;
        $newHeight = $height;
    } else {
        $newWidth = $width;
        $newHeight = $width / $aspectRatio;
    }

    // Create a new true color image with the desired dimensions
    $thumbnail = imagecreatetruecolor($newWidth, $newHeight);

    // Resize the image
    imagecopyresampled(
        $thumbnail,          // Destination image
        $sourceImage,       // Source image
        0,
        0,              // Destination x, y
        0,
        0,              // Source x, y
        $newWidth,          // Destination width
        $newHeight,         // Destination height
        $originalWidth,     // Source width
        $originalHeight     // Source height
    );

    // Save the resized image to the thumbnails directory
    $thumbnailPath = fileDirectory('thumbnails/' . $fileName);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbnail, $thumbnailPath, 90); // Save as JPEG with 90% quality
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbnail, $thumbnailPath, 9); // Save as PNG with maximum compression
            break;
        case IMAGETYPE_GIF:
            imagegif($thumbnail, $thumbnailPath); // Save as GIF
            break;
    }

    // Free up memory
    imagedestroy($sourceImage);
    imagedestroy($thumbnail);

    return true; // Return true on success
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

function singularToPlural($word)
{
    $lastLetter = substr($word, -1);
    $lastTwoLetters = substr($word, -2);
    if ($lastTwoLetters === 'us') {
        return substr($word, 0, -2) . 'i';
    } elseif ($lastTwoLetters === 'is') {
        return substr($word, 0, -2) . 'es';
    } elseif ($lastLetter === 'y' && !preg_match('/[aeiou]y$/i', $word)) {
        return substr($word, 0, -1) . 'ies';
    } elseif ($lastTwoLetters === 'fe') {
        return substr($word, 0, -2) . 'ves';
    } elseif ($lastLetter === 'f') {
        return substr($word, 0, -1) . 'ves';
    } elseif (in_array($lastLetter, ['s', 'x', 'z']) || in_array($lastTwoLetters, ['sh', 'ch'])) {
        return $word . 'es';
    } else {
        return $word . 's';
    }
}
