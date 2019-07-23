<?php

namespace App\Services\Order\Makers;

use App\Models\Clazz;
use App\Models\Order;
use App\Services\Order\Contracts\OrderMaker;
use App\Services\Order\Exceptions;
use App\Services\Order\OrderServiceFactory;

class ClassOrderMaker implements OrderMaker, \App\Constants\OrderConstants
{
    protected $product_pid;
    protected $mem_pid;
    protected $options;

    public function __construct( $product_pid, $mem_pid, $options = [] )
    {
        $this->product_pid = $product_pid;
        $this->mem_pid     = $mem_pid;
        $this->options     = collect( $options );
    }

    /**
     * Create New Order via Clazz Model
     *
     * @uses \App\Services\Order\Builders\ClassOrderBuilder::createOrder()
     * @uses \App\Services\Order\Builders\OnedayOrderBuilder::createOrder()
     * @uses \App\Services\Order\Builders\GlessonOrderBuilder::createOrder()
     */
    public function store()
    {
        try {
            $class = $this->product( $this->product_pid, $this->mem_pid );
            return OrderServiceFactory::builder( $class->product_type, $class, $this->mem_pid, $this->options )->createOrder();
        } catch ( \Exceoption $e ) {
            throw new Exceptions\OrderException( __( 'order.error_order' ), HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function product( $product_pid, $mem_pid )
    {
        return $this->validate( Clazz::detail( $product_pid )->orderable( $mem_pid )->first() );
    }

    protected function validate( Clazz $class )
    {
        if ( ! $class ) {
            throw new Exceptions\OrderException( __( 'order.not_found_class' ), HTTP_BAD_REQUEST );
        }

        // if ( @$this->validate['is_ordered'] && $class->is_ordered ) {
        //     throw new Exceptions\OrderException( __( 'order.already_order' ), 400 );
        // }

        // if ( @$this->validate['is_orderable'] && ! $class->isOrderable() ) {
        //     throw new Exceptions\OrderException( __( 'order.is_closed' ), 400 );
        // }

        if ( ! empty( $this->validate['is_started'] ) && $class->isStarted() ) {
            throw new Exceptions\OrderException( __( 'order.already_started' ), 400 );
        }

        return $class;
    }
}