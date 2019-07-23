<?php

namespace App\Services\Order\Builders;

use App\Models\ClassRoom;

trait RommPrice
{
    /**
     * Arrange Romm Price to Order
     */
    protected function arrangeRoomPrice( $room_pids, $lesson_time, $lesson_weeks, $rental_fee = 5000 )
    {
        $room_prices = collect();
        $room_pids   = collect( str_explode( $room_pids ) );

        $room_pids->each( function ( $pid ) use ( $room_prices, $lesson_time, $lesson_weeks, $rental_fee ) {
            if ( $room = ClassRoom::find( $pid ) ) {
                if ( $room->attributeIs( 'room_type_personal', 0 ) ) {
                    $room_prices->push( $rental_fee * $lesson_time * $lesson_weeks );
                }
            }
        } );

        optional( $this->order )->room_price  = $room_prices->sum();
        optional( $this->order )->room_prices = $room_prices->implode( '|' );
    }
}