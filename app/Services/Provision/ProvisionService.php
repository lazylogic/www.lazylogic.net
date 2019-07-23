<?php

namespace App\Services\Provision;

use App\Foundation\Logging;

class ProvisionService
{
    use Logging;

    /**
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     *
     * @param   \App\Models\Order|int   $order      product_type: CLASS | ONEDAY | GLESSON | LESSON | ASSESSMENT | ...
     * @param   int                     $mem_pid
     * @param   array                   $options
     *
     * @return  mixed
     */
    public function store( $order, $mem_pid, $options = [] )
    {
        $order = $this->order( $order, $mem_pid );
        return ProvisionServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->store();
    }

    /**
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     *
     * @param   \App\Models\Order|int   $order      product_type: CLASS | ONEDAY | GLESSON | LESSON | ASSESSMENT | ...
     * @param   int                     $mem_pid
     * @param   array                   $options
     *
     * @return  mixed
     */
    public function activate( $order, $mem_pid, $options = [] )
    {
        $order = $this->order( $order, $mem_pid );
        return ProvisionServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->activate();
    }

    /**
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     *
     * @param   \App\Models\Order|int   $order      product_type: CLASS | ONEDAY | GLESSON | LESSON | ASSESSMENT | ...
     * @param   int                     $mem_pid
     * @param   array                   $options
     *
     * @return  mixed
     */
    public function cancel( $order, $mem_pid, $options = [] )
    {
        $order = $this->order( $order, $mem_pid );
        return ProvisionServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->cancel();
    }

    /**
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     *
     * @param   \App\Models\Order|int   $order      product_type: CLASS | ONEDAY | GLESSON | LESSON | ASSESSMENT | ...
     * @param   int                     $mem_pid
     * @param   array                   $options
     *
     * @return  mixed
     */
    public function refund( $order, $mem_pid, $options = [] )
    {
        $order = $this->order( $order, $mem_pid );
        return ProvisionServiceFactory::broker( $order->product_type, $order, $mem_pid, $options )->refund();
    }

    ///////////////////////////////////////////////////////////////////////////
    //
    //  Utils
    //
    ///////////////////////////////////////////////////////////////////////////
    public function order( $order, $mem_pid )
    {
        return is_numeric( $order ) ? OrderService::order( $order, $mem_pid ) : $order;
    }

}