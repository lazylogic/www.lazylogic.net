<?php

namespace App\Services\Provision\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 *
 * @see \App\Services\Provision\ProvisionService
 */
class ProvisionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Provision\ProvisionService::class;
    }
}