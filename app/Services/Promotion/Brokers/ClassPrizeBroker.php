<?php

namespace App\Services\Promotion\Brokers;

use App\Services\Order\Exceptions\OrderException;
use App\Services\Order\Facades\OrderService;
use App\Services\Promotion\Contracts\PrizeBroker;
use App\Services\Promotion\Exceptions;

class ClassPrizeBroker extends EventBroker implements PrizeBroker
{
    /**
     * Create New Order via Event prize.
     *
     * If free event than complete the order.
     */
    public function complete()
    {
        try {
            $order = OrderService::store( TYPE_CLASS, $this->event->prize_pid, $this->mem_pid, [
                'event_type'   => $this->event->event_type,
                'event_reward' => $this->event->event_reward,
            ] );
            return $this->event->isFree() ? OrderService::complete( $order->pid(), $this->mem_pid ) : $order;
        } catch ( OrderException $e ) {
            throw new Exceptions\PromotionException( $e );
        }
    }
}