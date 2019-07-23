<?php

namespace App\Services\Provision\Contracts;

use App\Models\Order;

interface ProvisionBroker
{
    /**
     * Product provisioning
     *
     * @throws  \App\Services\Provision\Exceptions\ProvisionException
     *
     * @return  mixed
     */
    public function store();

    /**
     * Activate
     *
     * @throws  \App\Services\Provision\Exceptions\ProvisionException
     *
     * @return  mixed
     */
    public function activate();

    /**
     * Extend provisioning
     *
     * @throws  \App\Services\Provision\Exceptions\ProvisionException
     *
     * @return  mixed
     */
    public function extend();

    /**
     * Cancel
     *
     * @throws  \App\Services\Provision\Exceptions\ProvisionException
     *
     * @return  mixed
     */
    public function cancel();

    /**
     * Refund
     *
     * @throws  \App\Services\Provision\Exceptions\ProvisionException
     *
     * @return  mixed
     */
    public function refund();

}