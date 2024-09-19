<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\Product;

class AddProductGallery
{
    public function handle($product)
    {
        $request = request();
        $gallery = $request->get('gallery');
        if (is_array($gallery)) {
            $position = 0;
            $user_type = $request->user()::class;
            $user_id = $request->user()->id;
            foreach ($gallery as $key => $value) {
                if (function_exists('saveFileToGallery')) {
                    saveFileToGallery([
                        'tableable_type' => Product::class,
                        'tableable_id' => $product->id,
                        'position' => $position,
                        'path' => $value['path'],
                        'user_type' => $user_type,
                        'user_id' => $user_id
                    ], true);
                }
                if ($key == 0) {
                    $this->addMainPicture($product, $value['path']);
                }
                $position++;
            }
        }
    }

    protected function addMainPicture($product, $path)
    {
        $pic_name = str_replace('gallery/', '', $path);
        $product->image = $pic_name;
        $product->update();
        create_fit_pic($path, $pic_name);
    }
}
