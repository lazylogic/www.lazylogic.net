<?php

namespace App\Services\Order\Builders;

use App\Foundation\Logging;
use App\Models\Lesson;
use App\Models\Order;
use App\Services\Order\Contracts\OrderBuilder;
use App\Services\Order\Exceptions;

class LessonOrderBuilder implements OrderBuilder, \App\Constants\OrderConstants, \App\Constants\LessonConstants
{
    use Logging;

    // TODO:
}