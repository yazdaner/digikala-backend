<?php

namespace Modules\normaldelivery\App\Events;

class NormalSubmission
{
    protected array $intervals;
    protected array $filteredProducts = [];
    protected int $perparation_time = 0;
    protected int $totalPrice = 0;
    protected int $finalPrice = 0;
    protected array $selectedKeys = [];
    protected int $sender;

    public function handle($data)
    {
        $products = $data['products'];
        $this->sender = $data['sender'];
        $request = request();
        if(defined('address_id')){
            $address = runEvent('address-detail',[
                'id' => address_id,
                'user_id' => $request->user()->id,
            ],true);
            if($address){
                $this->productsFiltering($products);
                $intervals = $this->getTimeIntervals(
                    $address->id,
                    $this->sender
                );
                return [
                    'selected_keys' => $this->selectedKeys,
                    'products' => $this->filteredProducts,
                    'intervals' => $intervals,
                    'component' => 'normal-submission',
                    'totalPrice' => $this->totalPrice,
                    'finalPrice' => $this->finalPrice,
                    'icon' => assert('upload/normal-delivery.png'),
                    'name' => 'normal-delivery',
                    'sender' => $this->sender,
                ];
            }
        }
    }

    protected function productsFiltering($products)
    {
        foreach ($products as $key => $product) {
            $variation = $product->variation;
            if($product->product_dimensions == 'small' ||
                $product->product_dimensions == 'medium'){
                    
                }
        }
    }
}
