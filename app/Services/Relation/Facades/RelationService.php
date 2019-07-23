<?php

namespace App\Services\Relation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 *
 * @see \App\Services\Relation\RelationService
 */
class RelationService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Relation\RelationService::class;
    }
}