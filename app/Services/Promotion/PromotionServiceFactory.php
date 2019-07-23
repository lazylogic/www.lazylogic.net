<?php

namespace App\Services\Promotion;

use App\Services\ServiceFactory;

class PromotionServiceFactory extends ServiceFactory implements \App\Constants\EventConstants
{
    protected static $agent = [
        TYPE_FACEBOOK  => Agents\FacebookAgent::class,
        TYPE_INSTAGRAM => Agents\InstagramAgent::class,
        TYPE_KAKAOTALK => Agents\KakaotalkAgent::class,
    ];

    protected static $broker = [
        TYPE_CLASS      => Brokers\ClassPrizeBroker::class,
        TYPE_LESSON     => Brokers\LessonPrizeBroker::class,
        TYPE_ONLINE     => Brokers\OnlinePrizeBroker::class,
        TYPE_ASSESSMENT => Brokers\AssessmentPrizeBroker::class,
        TYPE_PACKAGE    => Brokers\PackagePrizeBroker::class,
        TYPE_COUPON     => Brokers\CouponPrizeBroker::class,
        TYPE_POINT      => Brokers\PointPrizeBroker::class,
        TYPE_DEFAULT    => Brokers\DefaultPrizeBroker::class,
    ];

}