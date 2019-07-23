<?php

namespace App\Services\Promotion\Contracts;

interface ParticipationAgent
{
    /**
     * 이벤트 참여 요청
     *
     * @throws  \App\Services\Promotion\Exceptions\PromotionException
     *
     * @return  mixed
     */
    public function participate();

    /**
     * 이벤트 참여 처리
     *
     * @throws  \App\Services\Promotion\Exceptions\PromotionException
     *
     * @return  mixed
     */
    public function apply();
}