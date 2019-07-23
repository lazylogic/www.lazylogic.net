<?php

namespace App\Services\Order\Contracts;

use App\Models\Order;

interface OrderMaker
{
    /**
     * Initialize(create) Order via Product Clazz | Lesson | Package | Assessment ...
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function store();

    /**
     * Load Product Clazz | Lesson | Package | Assessment ...
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  mixed
     */
    public function product( $product_pid, $mem_pid );
}