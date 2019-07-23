<?php

namespace App\Services\Order\Contracts;

use App\Models\Order;

interface OrderBroker
{
    /**
     * Order Options
     *
     * 포인트, 쿠폰 등 결제 옵션 정보
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  mixed
     */
    public function options();

    /**
     * Checkout Order
     *
     * 포인트, 쿠폰 사용 등 실제 주문 처리
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function checkout();

    /**
     * Complete Order
     *
     * 주문 완료, 데이터(lesson schdule) 생성 등
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function complete();

    /**
     * Request Order
     *
     * 주문 취소/환불 요청
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function request();

    /**
     * Cancel Order
     *
     * 주문 취소
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function cancel();

    /**
     * Refund Order
     *
     * 주문 환불
     *
     * @throws  \App\Services\Order\Exceptions\OrderException
     *
     * @return  \App\Models\Order
     */
    public function refund();
}