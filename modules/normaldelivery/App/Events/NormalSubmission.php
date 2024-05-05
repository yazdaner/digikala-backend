<?php

namespace Modules\normaldelivery\App\Events;

use Modules\normaldelivery\App\Events\_TimeIntervals;

class NormalSubmission extends _TimeIntervals
{
    protected array $intervals;
    protected array $filteredProducts = [];
    protected int $preparation_time = 0;
    protected int $totalPrice = 0;
    protected int $finalPrice = 0;
    protected array $selectedKeys = [];
    protected int $sender;

    public function handle($data)
    {
        $products = $data['products'];
        $this->sender = $data['sender'];
        $request = request();
        if (defined('address_id')) {
            $address = runEvent('address-detail', [
                'id' => address_id,
                'user_id' => $request->user()->id,
            ], true);
            if ($address) {
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
                    'shipping-cost' => $this->shippingCost($address->city_id),
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
            // \Log::info(var_export($product,true));
            if (
                $product->product_dimensions == 'small' ||
                $product->product_dimensions == 'medium'
            ) {
                $add = false;
                if (($this->sender > 0 && $variation->seller_id == $this->sender) ||
                    ($this->sender == 0 && $variation->seller_id == null)
                ) {
                    $add = true;
                }
                if ($add) {
                    $this->filteredProducts[] = $product;
                    $this->selectedKeys[] = $key;
                    $this->totalPrice += ($variation->price1 * $product->count);
                    $this->finalPrice += ($variation->price2 * $product->count);
                    if ($variation->preparation_time > $this->preparation_time) {
                        $this->preparation_time = $variation->preparation_time;
                    }
                }
            }
        }
    }

    protected function shippingCost($city_id): int
    {
        $senderKey = $this->sender == 0 ? '' : "sender_{$this->sender}_";
        $normal_shipping_cost = runEvent(
            'setting:value',
            $senderKey . "normal_shipping_cost_{$city_id}",
            true
        );
        $min_buy_free_normal_shipping = runEvent(
            'setting:value',
            $senderKey . "min_buy_free_normal_shipping_{$city_id}",
            true
        );

        if (!$normal_shipping_cost) {
            $normal_shipping_cost = runEvent(
                'setting:value',
                $senderKey . "normal_shipping_cost",
                true
            );
            $min_buy_free_normal_shipping = runEvent(
                'setting:value',
                $senderKey . "min_buy_free_normal_shipping",
                true
            );
        }

        if ($this->totalPrice >= $min_buy_free_normal_shipping) {
            return 0;
        } else {
            return $normal_shipping_cost;
        }
    }
}
