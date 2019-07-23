<?php

namespace App\Services\Order\Builders;

use App\Models\Clazz;
use App\Models\Order;

/**
 * Create Order via Glesson Clazz
 */
class GlessonOrderBuilder extends ClassBuilder
{
    /**
     * @modified    2018.02.22  razy    그룹레슨은 대관료를 받지 않도록 한다
     */
    protected function arrangeRoom()
    {
        $this->order->room_price  = 0;
        $this->order->room_prices = '';
    }

    /**
     * 정기 레슨은 무료 판매 또는 이벤트를 하지 않는다
     */
    protected function arrangeFree()
    {
        return parent::arrangeFree();
        return false;
    }

    /**
     * 정기 레슨은 할인 판매 또는 이벤트를 하지 않는다
     */
    protected function arrangeDiscount()
    {
        return parent::arrangeDiscount();
        return false;
    }

}