<?php

namespace Modules\faq\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategories extends Model
{
    use SoftDeletes;

    protected $table = 'faq__categories';
    protected $guarded = [];

    public static function search($data)
    {
        $faqCategories = self::query();
        $faqCategories->orderBy('id', 'DESC');
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $faqCategories->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $faqCategories->where('name', 'like', '%' . $data['name'] . '%');
        }
        return $faqCategories->paginate(env('PAGINATE'));
    }
}


