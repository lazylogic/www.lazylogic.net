<?php

namespace App\Foundation;

trait Logging
{
    protected static function info( $msg, ...$data )
    {
        \Log::info( static::log_formatter( $msg ), $data );
    }

    protected static function debug( $msg, ...$data )
    {
        \Log::debug( static::log_formatter( $msg ), $data );
    }

    protected static function warn( $msg, ...$data )
    {
        \Log::warning( static::log_formatter( $msg ), $data );
    }

    protected static function err( $msg, ...$data )
    {
        \Log::error( static::log_formatter( $msg ), $data );
    }

    protected static function log_formatter( $msg, ...$data )
    {
        return static::class . ' ' . ( is_string( $msg ) ? $msg : print_r( $msg, true ) );
    }
}