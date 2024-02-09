<?php

namespace Modules\sliders\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\sliders\database\factories\SliderFactory;

class Slider extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'sliders';
    protected $guarded = [];

    protected static function newFactory()
    {
        return SliderFactory::new();
    }

    public static function search($data)
    {
        $sliders = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $sliders = $sliders->onlyTrashed();
        }
        return $sliders->paginate(env('PAGINATE'));
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


