<?php

namespace App\Services\Provision\Builders;

use App\Foundation\Logging;
use App\Models\ClassReserve as Reserve;
use App\Models\Order;
use App\Services\Provision\Exceptions;

/**
 * Online Class Provision Builder
 */
class ClassProvisionBuilder extends BaseBuilder implements ProvisionBuilder, \App\Constants\ClassConstants
{
    use Logging;

    public function createReserve()
    {
        //
    }
}