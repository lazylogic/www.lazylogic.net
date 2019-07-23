<?php

namespace App\Services\Promotion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 *
 * @see \App\Services\Promotion\PromotionService
 */
class PromotionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Promotion\PromotionService::class;
    }
}