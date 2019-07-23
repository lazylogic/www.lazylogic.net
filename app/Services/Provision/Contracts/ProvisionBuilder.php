<?php

namespace App\Services\Provision\Contracts;

interface ProvisionBuilder
{
    /**
     * Create a class reserve from order.
     *
     * @throws  \App\Services\Provision\Exceptions\ProvisionException
     *
     * @return  mixed
     */
    public function createReserve();

}