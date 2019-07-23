<?php

namespace App\Services\Promotion\Agents;

use App\Models\Event;

abstract class EventAgent
{
    protected $event;
    protected $mem_pid;
    protected $options;

    public function __construct( Event $event, $mem_pid, $options = [] )
    {
        $this->event   = $event;
        $this->mem_pid = $mem_pid;
        $this->options = collect( $this->options )->merge( $options );
    }

}