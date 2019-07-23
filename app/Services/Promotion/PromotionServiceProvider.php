<?php

namespace App\Services\Promotion;

use Illuminate\Support\ServiceProvider;

class PromotionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind( 'App\Services\Promotion\PromotionService' );
    }
}