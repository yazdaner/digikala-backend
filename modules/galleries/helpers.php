<?php

use Intervention\Image\ImageManager;
use Modules\galleries\App\Models\Gallery;

// function saveFileToGallery($data, $watermark = false)
// {
//     $gallery = Gallery::where($data)->first();
//     if ($gallery == null) {
//         Gallery::create($data);
//         if ($watermark && config('gallery.watermark') == 'true') {
//             $manager = ImageManager::gd();
//             $img = $manager->read(fileDirectory($data['path']));
//             $img->place(
//                 fileDirectory(config('gallery.image')),
//                 config('gallery.position'),
//                 intval(config('gallery.position_x')),
//                 intval(config('gallery.position_y')),
//                 intval(config('gallery.opacity'))
//             );
//             $img->save();
//         }
//     }
// }


function saveFileToGallery($data, $watermark = false)
{
    // Check if the gallery entry already exists
    $gallery = Gallery::where($data)->first();
    if ($gallery == null) {
        // Create a new gallery entry
        Gallery::create($data);

        // Apply watermark if enabled
        if ($watermark && config('gallery.watermark') == 'true') {
            // Get the path to the source image
            $sourceImagePath = fileDirectory($data['path']);

            // Get the path to the watermark image
            $watermarkImagePath = fileDirectory(config('gallery.image'));

            // Load the source image
            $sourceImage = loadImage($sourceImagePath);
            if ($sourceImage === false) {
                error_log("Failed to load source image: " . $sourceImagePath);
                return;
            }

            // Load the watermark image
            $watermarkImage = loadImage($watermarkImagePath);
            if ($watermarkImage === false) {
                error_log("Failed to load watermark image: " . $watermarkImagePath);
                imagedestroy($sourceImage); // Free memory
                return;
            }

            // Get dimensions of the source and watermark images
            $sourceWidth = imagesx($sourceImage);
            $sourceHeight = imagesy($sourceImage);
            $watermarkWidth = imagesx($watermarkImage);
            $watermarkHeight = imagesy($watermarkImage);

            // Calculate watermark position
            $position = config('gallery.position', 'bottom-right');
            $positionX = intval(config('gallery.position_x', 10));
            $positionY = intval(config('gallery.position_y', 10));

            list($destX, $destY) = calculateWatermarkPosition(
                $position,
                $sourceWidth,
                $sourceHeight,
                $watermarkWidth,
                $watermarkHeight,
                $positionX,
                $positionY
            );

            // Apply watermark with opacity
            $opacity = intval(config('gallery.opacity', 50));
            applyWatermark($sourceImage, $watermarkImage, $destX, $destY, $opacity);

            // Save the watermarked image
            saveImage($sourceImage, $sourceImagePath);

            // Free memory
            imagedestroy($sourceImage);
            imagedestroy($watermarkImage);
        }
    }
}

/**
 * Load an image from a file path.
 *
 * @param string $path
 * @return resource|false
 */
function loadImage($path)
{
    $imageInfo = getimagesize($path);
    if ($imageInfo === false) {
        return false;
    }

    $imageType = $imageInfo[2]; // Get the image type (IMAGETYPE_JPEG, IMAGETYPE_PNG, etc.)

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($path);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($path);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($path);
        default:
            return false;
    }
}

/**
 * Save an image to a file path.
 *
 * @param resource $image
 * @param string $path
 */
function saveImage($image, $path)
{
    $imageInfo = getimagesize($path);
    if ($imageInfo === false) {
        return;
    }

    $imageType = $imageInfo[2]; // Get the image type (IMAGETYPE_JPEG, IMAGETYPE_PNG, etc.)

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($image, $path, 90); // Save as JPEG with 90% quality
            break;
        case IMAGETYPE_PNG:
            imagepng($image, $path, 9); // Save as PNG with maximum compression
            break;
        case IMAGETYPE_GIF:
            imagegif($image, $path); // Save as GIF
            break;
    }
}

/**
 * Calculate the watermark position based on the specified alignment.
 *
 * @param string $position
 * @param int $sourceWidth
 * @param int $sourceHeight
 * @param int $watermarkWidth
 * @param int $watermarkHeight
 * @param int $offsetX
 * @param int $offsetY
 * @return array
 */
function calculateWatermarkPosition($position, $sourceWidth, $sourceHeight, $watermarkWidth, $watermarkHeight, $offsetX, $offsetY)
{
    switch ($position) {
        case 'top-left':
            return [$offsetX, $offsetY];
        case 'top-right':
            return [$sourceWidth - $watermarkWidth - $offsetX, $offsetY];
        case 'bottom-left':
            return [$offsetX, $sourceHeight - $watermarkHeight - $offsetY];
        case 'bottom-right':
            return [$sourceWidth - $watermarkWidth - $offsetX, $sourceHeight - $watermarkHeight - $offsetY];
        case 'center':
            return [($sourceWidth - $watermarkWidth) / 2, ($sourceHeight - $watermarkHeight) / 2];
        default:
            return [$offsetX, $offsetY];
    }
}

/**
 * Apply a watermark to an image with the specified opacity.
 *
 * @param resource $sourceImage
 * @param resource $watermarkImage
 * @param int $destX
 * @param int $destY
 * @param int $opacity
 */
function applyWatermark($sourceImage, $watermarkImage, $destX, $destY, $opacity)
{
    // Loop through each pixel of the watermark image
    for ($x = 0; $x < imagesx($watermarkImage); $x++) {
        for ($y = 0; $y < imagesy($watermarkImage); $y++) {
            // Get the color of the watermark pixel
            $color = imagecolorsforindex($watermarkImage, imagecolorat($watermarkImage, $x, $y));

            // Calculate the new color with opacity
            $alpha = 127 - (($opacity / 100) * 127); // Convert opacity to alpha value
            $color['alpha'] = $alpha;

            // Allocate the color in the source image
            $colorIndex = imagecolorallocatealpha(
                $sourceImage,
                $color['red'],
                $color['green'],
                $color['blue'],
                $color['alpha']
            );

            // Apply the color to the source image
            imagesetpixel($sourceImage, $destX + $x, $destY + $y, $colorIndex);
        }
    }
}
