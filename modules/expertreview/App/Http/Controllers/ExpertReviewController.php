<?php

namespace Modules\expertreview\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\expertreview\App\Models\ExpertReview;
use Modules\core\App\Http\Controllers\CrudController;
use Modules\expertreview\App\Http\Requests\ExpertReviewRequest;

class ExpertReviewController extends CrudController
{
    protected $model = ExpertReview::class;

    public function index($product_id, Request $request)
    {
        $data = $request->all();
        $data['product_id'] = $product_id;
        $reviews = ExpertReview::search($data);
        return [
            'reviews' => $reviews,
            'trashCount' => ExpertReview::onlyTrashed()->count(),
        ];
    }

    public function store($product_id, ExpertReviewRequest $request)
    {
        $product = runEvent('product:query', function ($query) use ($product_id) {
            return $query->where('id', $product_id)->first();
        }, true);

        if ($product == null) {
            return ['status' => 'error', 'message' => 'محصول مورد نظر یافت نشد'];
        }

        $model = new ExpertReview($request->all());
        $model->product_id = $product_id;
        $model->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return ExpertReview::findOrFail($id);
    }

    public function update($id, ExpertReviewRequest $request)
    {
        $model = ExpertReview::findOrFail($id);
        $model->update($request->all());
        return ['status' => 'ok'];
    }

    public function all($product_id)
    {
        return ExpertReview::where('product_id', $product_id)->get();
    }
}
