<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // @created    2018.11.14  razy    max key length is 767 bytes
        Schema::defaultStringLength( 191 );

        // @created    2018.11.14  razy    set database listener
        \DB::listen( function ( $query ) {
            \Log::debug( $query->sql );
            \Log::debug( $query->bindings );
            \Log::debug( $query->time );
        } );

        // @created    2019.03.08  razy    set relation morph map
        Relation::morphMap( [

            // Product
            TYPE_CLASS      => 'App\Models\Clazz',
            TYPE_ONLINE     => 'App\Models\Clazz',
            TYPE_LESSON     => 'App\Models\Teacher',
            TYPE_ASSESSMENT => 'App\Models\Assessment',
            TYPE_PACKAGE    => 'App\Models\Package',

            // Reward
            TYPE_POINT      => 'App\Models\Point',
            TYPE_COUPON     => 'App\Models\Coupon',

            // Resource
            TYPE_VIDEO      => 'App\Models\Video',
            TYPE_IMAGE      => 'App\Models\Image',

            // TEST
            'TCLASS'        => 'App\Models\TestClass',
            'TLESSON'       => 'App\Models\TestLesson',

        ] );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}