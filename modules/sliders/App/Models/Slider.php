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
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

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
        return $sliders->paginate(10);
    }
}


