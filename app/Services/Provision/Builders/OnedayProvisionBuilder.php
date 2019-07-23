<?php

namespace App\Services\Provision\Builders;

/**
 * Oneday Provision Builder
 */
class OnedayProvisionBuilder extends LessonBuilder
{
    /**
     *  일일 특강은 스케쥴을 생성하지 않는다
     */
    protected function arrangeSchedules()
    {
        return null;
    }
}