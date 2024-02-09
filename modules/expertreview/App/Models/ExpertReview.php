<?php

namespace Modules\expertreview\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\expertreview\database\factories\ExpertReviewFactory;

class ExpertReview extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'products__expert_review';
    protected $guarded = [];

    protected static function newFactory()
    {
        return ExpertReviewFactory::new();
    }

    public static function search($data)
    {
        $reviews = self::orderBy('id', 'DESC')
            ->where('product_id', $data['product_id']);

        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $reviews = $reviews->onlyTrashed();
        }

        return $reviews->paginate(env('PAGINATE'));
    }
}
