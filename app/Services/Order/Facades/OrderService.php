<?php

namespace App\Services\Order\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 *
 * @see \App\Services\Order\OrderService
 */
class OrderService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Order\OrderService::class;
    }
}