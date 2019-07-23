<?php

namespace App\Services\Order;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind( 'App\Services\Order\OrderService' );
    }
}