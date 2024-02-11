<?php

namespace Modules\galleries\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\galleries\database\factories\GalleryFactory;

class Gallery extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'galleries';
    protected $guarded = [];

    protected static function newFactory()
    {
        return GalleryFactory::new();
    }

    public static function search($data)
    {
        $galleries = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $galleries = $galleries->onlyTrashed();
        }
        return $galleries->paginate(env('PAGINATE'));
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($slider){
            if($slider->isForceDeleting()){
                if(!empty($slider->image) && file_exists('slider/'.$slider->image)){
                    unlink('slider/'.$slider->image);
                }
                if(!empty($slider->mobile_image) && file_exists('slider/'.$slider->mobile_image)){
                    unlink('slider/'.$slider->mobile_image);
                }
            }
        });
    }
}


