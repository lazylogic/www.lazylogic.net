<?php

namespace App\Services\Video;

use Illuminate\Support\ServiceProvider;

class VideoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind( 'App\Services\Video\VideoService' );
    }
}