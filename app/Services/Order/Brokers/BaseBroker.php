<?php

namespace App\Services\Order\Brokers;

use App\Foundation\Logging;
use App\Models\Order;
use App\Services\Order\Contracts\OrderBroker;
use App\Services\Order\Exceptions;
use App\Services\Provision\Facades\ProvisionService;

abstract class BaseBroker implements OrderBroker, \App\Constants\OrderConstants
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
     * @see  \App\Services\Order\Contracts\OrderBroker
     */
    public function options()
    {
        $result = collet( ['order', $this->order] );

        // 사용 가능한 쿠폰 정보
        $result->put( 'coupons', $this->coupons() );

        // 사용 가능한 포인트 정보
        $result->put( 'points', $this->points() );

        // 기타 결제에 사용 할 수 있는 옵션
        $result->put( 'methods', $this->methods() );

        return $this->result;
    }

    protected function coupons()
    {
        //return CouponService::coupons( $order, $mem_pid, $options );
    }

    protected function points()
    {
        //return PointService::points( $order, $mem_pid, $options );
    }

    protected function methods()
    {
        // return self::ORDER_METHODS;
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Order\Contracts\OrderBroker
     */
    public function checkout()
    {
        if ( $this->validate() ) {
            return $this->order;
        }
    }

    /**
     * @throws   \App\Services\Order\Exceptions\OrderException
     */
    protected function validate()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @see     \App\Services\Order\Contracts\OrderBroker
     * @used-by \App\Services\Payment\PaymentService
     * @used-by \App\Services\Promotion\Brokers\ClassPrizeBroker
     */
    public function complete()
    {
        try {
            if ( $res = ProvisionService::store( $this->order, $this->mem_pid, $this->options ) ) {
                $this->order->order_step = Order::STEP_FINISHED;
                $this->order->save();
                return $this->order;
            }
        } catch ( \Exception $e ) {
            throw new Exceptions\OrderException( $e );
        }
    }

    /**
     * @see  \App\Services\Order\Contracts\OrderBroker
     */
    public function request()
    {
        return $this->order;
    }

    /**
     * @see  \App\Services\Order\Contracts\OrderBroker
     */
    public function cancel()
    {
        try {

            // 결제 취소가 잘 되고
            // PaymentService::cancel( $order, $mem_pid, $options );

            // 상품 취소도 잘 되었으면
            // ProvisionService::cancel( $order, $mem_pid, $options );

            // 주문 상태를 취소 처리 한다
            // TODO:

            return $this->order;

        } catch ( \Exception $e ) {
            throw new Exceptions\OrderException( $e );
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Order\Contracts\OrderBroker
     */
    public function refund()
    {
        try {

            // 상품 취소 잘 되고
            // ProvisionService::cancel( $order, $mem_pid, $options );

            // 결제 환불 잘 되었으면
            // PaymentService::cancel( $order, $mem_pid, $options );

            // 주문 상태를 환불 처리 한다
            // TODO:

            return $this->order;
        } catch ( \Exception $e ) {
            throw new Exceptions\OrderException( $e );
        }
    }
}