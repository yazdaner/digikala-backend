<?php

use Modules\sellers\App\Models\Seller;

function updateAuthConfigs()
{
    $guards = config('auth.guards');
    $guards['seller'] = [
        'driver' => 'session',
        'provider' => 'seller_provider'
    ];
    config()->set('auth.guards', $guards);

    $providers = config('auth.providers');
    $providers['seller_provider'] = [
        'driver' => 'eloquent',
        'model' => Seller::class,
    ];
    config()->set('auth.providers', $providers);

    $passwords = config('auth.passwords');
    $passwords['seller'] = [
        'provider' => 'seller_provider',
        'table' => 'sellers__password_resets',
        'expire' => 60,
        'throttle' => 60,
    ];
    config()->set('auth.passwords', $passwords);
}
