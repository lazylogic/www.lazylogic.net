<?php

namespace App\Services\Order;

use App\Foundation\Logging;
use App\Models\Order;
use App\Services\Order\Makers\ClassOrderMaker;

class OrderService
{
    use Logging;

    /**
     * Order Info
     *
     * @param   int     $order_pid
     * @param   int     $mem_pid
     *
     * @throws  \App\Services\Order\Exceptions\OrderNotFoundException
     *
     * @return  \App\Models\Order
     */
    public function order( $order_pid, $mem_pid = null )
    {
        $order = Order::detail( $order_pid )->hasTo( $mem_pid )->first();

        if ( ! $order ) {
            throw new Exceptions\OrderNotFoundException( __( 'order.not_found' ), 400 );
        }

        return $order;
    }

    /**
     * @see  \App\Services\Order\Contracts\OrderBroker
     *
     * @param   string  $product_type      CLASS(CLASS,ONEDAY,GLESSON) | LESSON | PACKAGE | ASSESSMENT | ARTISTPACK ...
     */
    public function store( $product_type, $product_pid, $mem_pid, $options = [] )
    {
        return OrderServiceFactory::maker( $product_type, $product_pid, $mem_pid, $options )->store();
    }

    /**
     * @see \App\Services\Order\Contracts\OrderBroker
     */
    public function options( $order_pid, $mem_pid, $options = [] )
    {
        $order = $this->order( $order_pid, $mem_pid );
        return OrderServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->options();
    }

    /**
     * @see \App\Services\Order\Contracts\OrderBroker
     */
    public function checkout( $order_pid, $mem_pid, $options = [] )
    {
        $order = $this->order( $order_pid, $mem_pid );
        return OrderServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->checkout();
    }

    /**
     * @see \App\Services\Order\Contracts\OrderBroker
     */
    public function complete( $order_pid, $mem_pid, $options = [] )
    {
        $order = $this->order( $order_pid, $mem_pid );
        return OrderServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->complete();
    }

    /**
     * @see \App\Services\Order\Contracts\OrderBroker
     */
    public function request( $order_pid, $mem_pid, $options = [] )
    {
        $order = $this->order( $order_pid, $mem_pid );
        return OrderServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->request();
    }

    /**
     * @see \App\Services\Order\Contracts\OrderBroker
     */
    public function cancel( $order_pid, $mem_pid, $options = [] )
    {
        $order = $this->order( $order_pid, $mem_pid );

        if ( OrderServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->cancel() ) {
            PaymentService::cancel( $order, $mem_pid, $options );
        }

        throw new Exceptions\OrderException( __( 'order.error_cancel' ), 500 );
    }

    /**
     * @see \App\Services\Order\Contracts\OrderBroker
     */
    public function refund( $order_pid, $mem_pid, $options = [] )
    {
        $order = $this->order( $order_pid, $mem_pid );
        if ( OrderServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->refund() ) {
            PaymentService::refund( $order, $mem_pid, $options );
        }

        throw new Exceptions\OrderException( __( 'order.error_refund' ), 500 );
    }

}