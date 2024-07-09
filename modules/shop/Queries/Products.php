<?php

namespace Modules\shop\Queries;

use Illuminate\Database\Eloquent\Builder;

class Products
{
    protected array $data;

    protected Builder $query;

    protected array $searchMethods = [
        'category_id',
        'brand_id',
        'status',
        'variation',
        'text',
        'sort'
    ];

    public function __construct($data)
    {
        $this->data = $data;
        $this->createQuery();
    }

    protected function createQuery()
    {
        $this->query = runEvent('product:query', function ($query) {
            return $query->select(['id', 'slug', 'title', 'image', 'status']);
        }, true);
        foreach ($this->searchMethods as $method) {
            $this->$method();
        }
    }

    protected function result()
    {
        if (array_key_exists('limit', $this->data)) {
            return $this->query->offset(0)
                ->limit($this->data['limit'])
                ->get();
        } else {
            return $this->query->paginate(env('PAGINATE'));
        }
    }

    protected function category_id()
    {
        if (array_key_exists('category_id', $this->data) && !empty($this->data['category_id'])) {
            $this->query->where('category_id', intval($this->data['category_id']));
        }
    }

    protected function brand_id()
    {
        if (array_key_exists('brand_id', $this->data) && !empty($this->data['brand_id'])) {
            $this->query->where('brand_id', intval($this->data['brand_id']));
        }
    }

    protected function status()
    {
        if (array_key_exists('status', $this->data) && !empty($this->data['status'])) {
            $this->query->where('status', intval($this->data['status']));
        }
    }

    protected function variation()
    {
        if (array_key_exists('variation', $this->data) && $this->data['variation'] == 'true') {
            $this->query->with('variation')->whereHas('variation');
        }
    }

    protected function text()
    {
        if (array_key_exists('text', $this->data) && !empty($this->data['text'])) {
            $text = $this->data['text'];
            $searchValues = preg_split('/\s+/',$text);
            $this->query->where(function ($query) use ($searchValues){
                foreach ($searchValues as $value) {
                    $query->where('title','like','%'.$value.'%');
                }
            });
        }
    }

    protected function sort()
    {
        if (array_key_exists('orderBy', $this->data)) {
            switch (intval($this->data['orderBy'])) {
                case 21:
                    $this->query->orderBy('view', 'DESC');
                    break;
                case 23:
                    $this->query->orderBy('id', 'DESC');
                    break;
                case 24:
                    $this->query->orderBy('sales_count', 'DESC');
                    break;
            }
        } else {
            $this->query->orderBy('id', 'DESC');
        }
    }
}
