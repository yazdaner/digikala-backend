<?php

namespace Modules\promotions\App\Actions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\promotions\App\Models\Promotion;

class SearchPromotions extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $promotions = Promotion::query();
        $promotions->orderBy('id', 'DESC')
            ->with('category')
            ->withCount('products');

        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $promotions->onlyTrashed();
        }

        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $promotions->where('name', 'like', '%' . $data['name'] . '%');
        }

        if (array_key_exists('start_time', $data) && !empty($data['start_time'])) {
            $start_time = createTimestampFromDate($data['start_time']);
            $promotions->where('start_time', '>=', $start_time);
        }

        if (array_key_exists('end_time', $data) && !empty($data['end_time'])) {
            $end_time = createTimestampFromDate($data['end_time'],'23:59:59');
            $promotions->where('end_time', '<=', $end_time);
        }

        if (array_key_exists('type', $data) && !empty($data['type'])) {
            $promotions->where('type', $data['type']);
        }

        return $promotions->paginate(env('PAGINATE'));
    }
}
