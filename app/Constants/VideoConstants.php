<?php

namespace App\Constants;

interface VideoConstants
{
    const HOST_YOUTUBE = 'YOUTUBE';
    const HOST_VIMEO   = 'VIMEO';
    const HOST_KOLLUS  = 'KOLLUS';

    const TYPE_INTRO   = 'INTRO';
    const TYPE_FREE    = 'FREE';
    const TYPE_REGULAR = 'REGULAR';
    const VIDEO_TYPES  = [
        self::TYPE_INTRO   => 'Intro',
        self::TYPE_FREE    => 'Free',
        self::TYPE_REGULAR => 'Regular',
    ];
}