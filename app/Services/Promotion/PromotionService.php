<?php

namespace App\Services\Promotion;

use App\Foundation\Logging;
use App\Models\Event;
use App\Models\EventParticipation as Participation;

class PromotionService
{
    use Logging;

    /**
     * get Event.
     *
     * @param   int     $event_pid
     *
     * @throws  \App\Services\Promotion\Exceptions\PromotionNotFoundException
     *
     * @return  \App\Models\Event
     */
    public function event( $event_pid, $mem_pid = null, $options = [] )
    {
        $event = Event::detail( $event_pid, $mem_pid )->active()->first();

        if ( ! $event ) {
            throw new Exceptions\PromotionNotFoundException( __( 'promotion.not_found' ), HTTP_BAD_REQUEST );
        }

        return $event;
    }

    /**
     * @see  \App\Services\Promotion\Contracts\ParticipationAgent
     */
    public function participate( $event_pid, $mem_pid, $options = [] )
    {
        $event = $this->event( $event_pid, $mem_pid, $options );

        if ( $event->isCompleted() ) {
            throw new Exceptions\PromotionStatusException( __( 'promotion.already_complete' ), HTTP_CONFLICT );
        }

        if ( $result = PromotionServiceFactory::agent( $event->event_target, $event, $mem_pid, $options )->participate() ) {
            Participation::setParticipated( $event_pid, $mem_pid );
            return $result;
        }

        throw new Exceptions\PromotionException( __( 'promotion.error_participate' ), 500 );
    }

    /**
     * @see  \App\Services\Promotion\Contracts\ParticipationAgent
     */
    public function apply( $event_pid, $mem_pid, $options = [] )
    {
        $event = $this->event( $event_pid, $mem_pid, $options );

        if ( $event->isCompleted() ) {
            throw new Exceptions\PromotionStatusException( __( 'promotion.already_complete' ), HTTP_CONFLICT );
        }

        // 이벤트 target & method 에 따른 참여 처리
        if ( $result = PromotionServiceFactory::agent( $event->event_target, $event, $mem_pid, $options )->apply() ) {
            Participation::setApplied( $event_pid, $mem_pid );
            return $result;
        }

        throw new Exceptions\PromotionException( __( 'promotion.error_apply' ), HTTP_INTERNAL_SERVER_ERROR );
    }

    /**
     * @see  \App\Services\Promotion\Contracts\PrizeBroker
     */
    public function complete( $event_pid, $mem_pid, $options = [] )
    {
        $event = $this->event( $event_pid, $mem_pid, $options );

        if ( $event->isInitial() ) {
            throw new Exceptions\PromotionStatusException( __( 'promotion.not_apply' ), HTTP_CONFLICT );
        }

        if ( $event->isCompleted() ) {
            throw new Exceptions\PromotionStatusException( __( 'promotion.already_complete' ), HTTP_CONFLICT );
        }

        if ( $event->isClosed() ) {
            throw new Exceptions\PromotionStatusException( __( 'promotion.is_closed' ), HTTP_CONFLICT );
        }

        // 이벤트 Type 에 따른 완료(상품) 처리
        if ( $result = PromotionServiceFactory::broker( $event->prize_type, $event, $mem_pid, $options )->complete() ) {
            Participation::setCompleted( $event_pid, $mem_pid );
            return $result;
        }

        throw new Exceptions\PromotionException( __( 'promotion.error_complete' ), HTTP_INTERNAL_SERVER_ERROR );
    }
}