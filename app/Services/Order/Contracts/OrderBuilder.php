<?php

namespace App\Services\Order\Contracts;

interface OrderBuilder
{
    /**
     * Create & save a order from class(product).
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function createOrder();

}