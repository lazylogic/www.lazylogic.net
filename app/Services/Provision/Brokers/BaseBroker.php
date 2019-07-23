<?php

namespace App\Services\Provision\Brokers;

use App\Foundation\Logging;
use App\Models\LessonReserve as Reserve;
use App\Models\Order;
use App\Services\Provision\Contracts\ProvisionBroker;
use App\Services\Provision\Exceptions;
use App\Services\Provision\ProvisionServiceFactory;

class BaseBroker implements ProvisionBroker, \App\Constants\OrderConstants
{
    use Logging;

    protected $order;
    protected $mem_pid;
    protected $options;

    public function __construct( Order $order, $mem_pid, $options = [] )
    {
        $this->order   = $order;
        $this->mem_pid = $mem_pid;
        $this->options = collect( $this->options )->merge( $options );

    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     */
    public function store()
    {
        try {

            if ( ! $this->order->isCompleted() ) {
                throw new Exceptions\ProvisionException( __( 'order.not_complete' ), HTTP_CONFLICT );
            }

            if ( Reserve::where( 'order_lesson_pid', $this->order->pid() )->exists() ) {
                return true;
            }

            if ( optional( $this->order )->lesson_sday < date( 'Ymd' ) ) {
                throw new Exceptions\ProvisionException( __( 'order.already_started' ), HTTP_BAD_REQUEST );
            }

            return ProvisionServiceFactory::builder( $this->order->product_type, $this->order, $this->options )->createReserve();

        } catch ( \Exception $e ) {
            throw new Exceptions\ProvisionException( $e );
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     */
    public function activate()
    {
        try {
            return Reserve::where( 'order_lesson_pid', $this->order->order_lesson_pid )->update( ['lesson_status' => self::STATUS_NORMAL] );
        } catch ( \Exception $e ) {
            throw new Exceptions\ProvisionException( $e, HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     */
    public function extend()
    {
        //
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     */
    public function cancel()
    {
        //
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Provision\Contracts\ProvisionBroker
     */
    public function refund()
    {
        //
    }

}