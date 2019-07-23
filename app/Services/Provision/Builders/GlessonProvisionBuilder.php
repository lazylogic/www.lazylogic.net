<?php

namespace App\Services\Provision\Builders;

/**
 * GLesson Provision Builder
 */
class GlessonProvisionBuilder extends LessonBuilder
{
    /**
     * Glesson 정상 수수료율. 25%
     *
     * @return  int
     */
    protected function settleRate()
    {
        return self::SETTLE_RATE_GLESSON;
    }
}