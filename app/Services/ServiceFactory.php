<?php

namespace App\Services;

use App\Foundation\Logging;

abstract class ServiceFactory
{
    use Logging;

    protected static $instances = [];

    /**
     * Resolve a instance of type
     *
     * @param   string  $store  Target class store name
     * @param   string  $type   Target class type
     * @param   mixed   $params Target class constructor params
     *
     * @return  mixed
     */
    protected static function resolver( $store, $type, ...$params )
    {
        static::debug( "Try Finding a '{$type}' in '{$store}'" );

        if ( isset( static::$$store[$type] ) ) {
            return static::instance( static::$$store[$type], ...$params );
        }

        if ( ! empty( static::$$store[TYPE_DEFAULT] ) ) {
            return static::instance( static::$$store[TYPE_DEFAULT], ...$params );
        }

        throw new ServiceException( "Not fined '{$type}' in '{$store}'", HTTP_INTERNAL_SERVER_ERROR );
    }

    /**
     * Resolve a instance from the class
     *
     * @param   string  $class   Target Class. eg> FacebookAgent::class
     * @param   mixed   $params Target class constructor params
     *
     * @return  mixed
     */
    protected static function instance( $class, ...$params )
    {
        static::debug( "Resolving '{$class}'" );

        try {
            return new $class( ...$params );
            //return isset( static::$instances[$class] ) ? static::$instances[$class] : static::$instances[$class] = new $class( ...$params );
        } catch ( \Exception $e ) {
            throw new ServiceException( $e, HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Call Factory Method.
     *
     * @see http://php.net/manual/en/language.oop5.overloading.php#object.callstatic
     */
    public static function __callStatic( $name, $arguments )
    {
        return static::resolver( $name, strtoupper( @array_shift( $arguments ) ), ...$arguments );
    }
}