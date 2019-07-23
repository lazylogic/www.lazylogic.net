<?php

namespace App\Services\Promotion\Agents;

use App\Services\Promotion\Contracts\ParticipationAgent;

class FacebookAgent extends EventAgent implements ParticipationAgent
{
    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Promotion\Contracts\ParticipationAgent
     */
    public function participate()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @see  \App\Services\Promotion\Contracts\ParticipationAgent
     */
    public function apply()
    {
        return true;
    }
}