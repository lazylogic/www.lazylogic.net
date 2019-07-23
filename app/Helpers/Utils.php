<?php

use Illuminate\Contracts\Support\Arrayable;

if ( ! function_exists( 'pre' ) ) {
    function pre( $var )
    {
        echo '<pre>' . print_r( $var, 1 ) . '</pre>';
    }
}

if ( ! function_exists( 'not_null' ) ) {
    function not_null( $var )
    {
        return ! empty( $var );
    }
}

if ( ! function_exists( 'is_arrayable' ) ) {
    function is_arrayable( $value )
    {
        return is_array( $value ) || $value instanceof Arrayable;
    }
}

if ( ! function_exists( 'array_extract' ) ) {
    function array_extract( array $key, array $value, $keep = true )
    {
        return array_reduce( $key, function ( $o, $i ) use ( $value, $keep ) {
            if ( $keep || ( isset( $value[$i] ) && $value[$i] !== null ) ) {
                $o[$i] = isset( $value[$i] ) ? $value[$i] : null;
            }
            return $o;
        } );
    }
}

if ( ! function_exists( 'array_refine' ) ) {
    function array_refine( array $array, array $value, $keep = true )
    {
        return array_reduce( array_keys( $array ), function ( $o, $i ) use ( $array, $value, $keep ) {
            if ( $keep || ( isset( $value[$i] ) && $value[$i] !== null ) ) {
                $o[$i] = isset( $value[$i] ) ? @$value[$i] : @$array[$i];
            }
            return $o;
        } );
    }
}