<?php

namespace App\Services\Video\Strategies;

use App\Foundation\Attributable;
use App\Foundation\Logging;
use App\Models\Video;
use App\Services\Video\Contracts\VideoAgent;

class KollusVideoAgent implements VideoAgent, \App\Constants\VideoConstants
{
    use Logging;

    private $config = [];
    private $account;

    /**
     * Kollus Video Agent Constuctor
     *
     * - read config
     * - set Kollus User
     */
    public function __construct()
    {
        $this->config  = collect( \Config::get( 'kollus' ) );
        $this->account = new KollusAccount( $this->config->get( 'account' ) );
    }

    /**
     * Get Video Play Info.
     *
     * @param   \App\Models\Video|array $video
     * @param   int                     $mem_pid
     *
     * @return  mixed
     */
    public function play( $video, $mem_pid, $options = [] )
    {
        //
    }

    /**
     * Authorize the user
     *
     * @param   \App\Models\Video   $video
     * @param   int                 $mem_pid
     *
     * @return  mixed
     */
    public function auth( Video $video, $mem_pid, $options = [] )
    {
        //
    }
}

class KollusAccount
{
    use Attributable;

    public function __construct( $config = [] )
    {
        $this->setAttributes( $config );
    }
}

class KollusMedia
{
    use Attributable;

    public function __construct( $config = [] )
    {
        $this->setAttributes( $config );
    }
}