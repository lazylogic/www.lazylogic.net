<?php

namespace App\Services\Video\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Video\VideoService
 */
class VideoService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Video\VideoService::class;
    }
}