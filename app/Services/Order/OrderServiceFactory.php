<?php

namespace App\Services\Order;

use App\Services\ServiceFactory;

class OrderServiceFactory extends ServiceFactory
{
    protected static $builder = [
        TYPE_CLASS   => Builders\ClassOrderBuilder::class,
        TYPE_ONEDAY  => Builders\OnedayOrderBuilder::class,
        TYPE_GLESSON => Builders\GlessonOrderBuilder::class,
        TYPE_LESSON  => Builders\LessonOrderBuilder::class,
        TYPE_PACKAGE => Builders\PackageOrderBuilder::class,
    ];

    protected static $maker = [
        TYPE_CLASS   => Makers\ClassOrderMaker::class,   // via Clazz Model       use Class|Onday|Glesson Builder
        TYPE_LESSON  => Makers\LessonOrderMaker::class,  // via Lesson Model      use Lesson Builder
        TYPE_PACKAGE => Makers\PackageOrderMaker::class, // via Package Model     use Package Builder
    ];

    protected static $broker = [
        TYPE_CLASS   => Brokers\ClassOrderBroker::class,   // via Clazz Model      use Class Builder
        TYPE_ONEDAY  => Brokers\OnedayOrderBroker::class,  // via Clazz Model      use Oneday Builder
        TYPE_GLESSON => Brokers\GlessonOrderBroker::class, // via Clazz Model      use Glesson Builder
        TYPE_LESSON  => Brokers\LessonOrderBroker::class,  // via Lesson Model     use Lesson Builder
        TYPE_PACKAGE => Brokers\PackageOrderBroker::class, // via Package Model    use Package Builder
    ];

}