<?php

namespace App\Services\Provision;

use Illuminate\Support\ServiceProvider;

class ProvisionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind( 'App\Services\Provision\ProvisionService' );
    }
}