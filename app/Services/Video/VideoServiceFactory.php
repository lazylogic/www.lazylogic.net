<?php

namespace App\Services\Video;

use App\Services\ServiceFactory;

class VideoServiceFactory extends ServiceFactory implements \App\Constants\VideoConstants
{
    protected static $agent = [
        self::HOST_YOUTUBE => Strategies\YoutubeVideoAgent::class,
        self::HOST_VIMEO   => Strategies\VimeoVideoAgent::class,
        self::HOST_KOLLUS  => Strategies\KollusVideoAgent::class,
        TYPE_DEFAULT       => Strategies\KollusVideoAgent::class,
    ];

    protected static $broker = [
        TYPE_DEFAULT => Strategies\DefaultVideoBroker::class,
    ];

}