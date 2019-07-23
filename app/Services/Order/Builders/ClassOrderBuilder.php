<?php

namespace App\Services\Order\Builders;

use App\Models\Clazz;
use App\Models\Order;

/**
 * Create Order via Online Clazz
 */
class ClassOrderBuilder extends ClassBuilder
{
    protected function arrangeRoom()
    {
        $this->order->lesson_days = $this->class->class_period; // 수강 가능 기간
        $this->order->room_pids   = '';
        $this->order->room_price  = 0;
        $this->order->room_prices = '';
    }

}