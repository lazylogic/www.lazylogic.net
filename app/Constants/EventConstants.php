<?php

namespace App\Constants;

interface EventConstants
{
    const TYPE_FREE     = 'FREE';
    const TYPE_DISCOUNT = 'DISCOUNT';
    const TYPE_COUPON   = 'COUPON';
    const TYPE_POINT    = 'POINT';
    const EVENT_TYPES   = [
        self::TYPE_FREE     => '무료',
        self::TYPE_DISCOUNT => '할인',
        self::TYPE_COUPON   => '쿠폰',
        self::TYPE_POINT    => '포인트',
    ];
}