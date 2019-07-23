<?php

namespace App\Services\Provision;

use App\Services\ServiceFactory;

class ProvisionServiceFactory extends ServiceFactory
{
    // via Order->product_type
    protected static $broker = [
        TYPE_CLASS      => Brokers\ClassProvisionBroker::class,   // via Order.product_type   use Class Bulder
        TYPE_ONEDAY     => Brokers\OnedayProvisionBroker::class,  // via Order.product_type   use Oneday Bulder
        TYPE_GLESSON    => Brokers\GlessonProvisionBroker::class, // via Order.product_type   use Glasson Bulder
        TYPE_LESSON     => Brokers\LessonProvisionBroker::class,  // via Order.product_type   use Lasson Bulder
        TYPE_ASSESSMENT => Brokers\AssessmentProvisionBroker::class,
    ];

    // via Order->product_type
    protected static $builder = [
        TYPE_CLASS      => Builders\ClassProvisionBuilder::class,
        TYPE_ONEDAY     => Builders\OnedayProvisionBuilder::class,
        TYPE_GLESSON    => Builders\GlessonProvisionBuilder::class,
        TYPE_LESSON     => Builders\LessonProvisionBuilder::class,
        TYPE_ASSESSMENT => Builders\AssessmentProvisionBuilder::class,
    ];

}