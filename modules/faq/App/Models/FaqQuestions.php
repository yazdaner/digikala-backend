<?php

namespace Modules\faq\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\faq\App\Models\FaqCategories;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqQuestions extends Model
{
    use SoftDeletes;

    protected $table = 'faq__questions';
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(FaqCategories::class,'id','category_id');
    }

    public static function search($data)
    {
        $questions = self::query();
        $questions->orderBy('id', 'DESC')->with('category');
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $questions->onlyTrashed();
        }
        if (array_key_exists('title', $data) && !empty($data['title'])) {
            $questions->where('title', 'like', '%' . $data['title'] . '%');
        }
        return $questions->paginate(env('PAGINATE'));
    }
}


