<?php

use Intervention\Image\ImageManager;
use Modules\galleries\App\Models\Gallery;

function saveFileToGallery($data, $watermark = false)
{
    $gallery = Gallery::where($data)->first();
    if ($gallery == null) {
        Gallery::create($data);
        if ($watermark && config('gallery.watermark') == 'true') {
            $manager = ImageManager::gd();
            $img = $manager->read(fileDirectory($data['path']));
            $img->place(
                fileDirectory(config('gallery.image')),
                config('gallery.position'),
                intval(config('gallery.position_x')),
                intval(config('gallery.position_y')),
                intval(config('gallery.opacity'))
            );
            $img->save();
        }
    }
}
