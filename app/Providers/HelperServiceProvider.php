<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro( 'is', function ( $key, $value ) {
            return $this->get( $key ) == $value;
        } );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ( glob( app_path() . '/Helpers/*.php' ) as $file ) {
            require_once $file;
        }
    }
}