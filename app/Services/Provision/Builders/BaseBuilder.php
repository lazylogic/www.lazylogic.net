<?php

namespace App\Services\Provision\Builders;

use App\Foundation\Logging;
use App\Models\Order;

/**
 * Offline Class & Lesson Provision Builder
 */
abstract class BaseBuilder
{
    use Logging;

    protected $order;
    protected $options;
    protected $reserve;

    public function __construct( Order $order, $options = [] )
    {
        $this->order   = $order;
        $this->options = collect( $this->options )->merge( $options );
    }

}