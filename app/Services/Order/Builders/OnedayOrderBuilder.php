<?php

namespace App\Services\Order\Builders;

use App\Models\Clazz;
use App\Models\Order;

/**
 * Create Order via Oneday Clazz
 */
class OnedayOrderBuilder extends ClassBuilder
{
    /**
     * @modified    2018.02.22  razy    그룹레슨은 대관료를 받지 않도록 한다
     */
    protected function arrangeRoom()
    {
        $this->order->lesson_days = 1; // 일일 특강은 스케쥴을 생성하지 않는다
        $this->order->room_price  = 0;
        $this->order->room_prices = '';
    }

}