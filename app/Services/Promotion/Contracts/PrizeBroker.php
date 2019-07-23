<?php

namespace App\Services\Promotion\Contracts;

interface PrizeBroker
{
    /**
     * 이벤트 참여자 완료(상품) 처리
     *
     * @throws  \App\Services\Promotion\Exceptions\PromotionException
     *
     * @return  mixed
     */
    public function complete();
}