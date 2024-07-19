<?php

namespace Modules\sellers\App\Events;

use Illuminate\Support\Facades\Auth;

class SellerAccess
{
    public function handle($data)
    {
        $access = false;
        if(Auth::guard('seller')->check()){
            foreach ($this->accessRoute as $route) {
                if($data['uri'] == $route){
                    $access = true;
                }
            }
        }    
        return $access;    
    }
    protected array $accessRoute = [
        'api/admin/product/gallery',
        'api/admin/products',
        'api/admin/products/{product_id}/variations',
        'api/admin/products/{product_id}/variations/store',
        'api/admin/products/variations/{id}/update',
        'api/admin/products/variations/{id}/show',
    ];
}
