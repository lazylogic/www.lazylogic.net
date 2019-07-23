<?php

namespace App\Constants;

interface OrderConstants
{
    /**
     * order_lesson.order_step
     */
    const STEP_INITIAL  = '00'; // 주문서 작성
    const STEP_PENDING  = '01'; // 결제 대기
    const STEP_APPROVAL = '02'; // 결제 허락(?)
    const STEP_REQUEST  = '10'; // 결제 요청
    const STEP_FINISHED = '99'; // PG사 결과 확인

    /**
     * order_lesson.pg_res_status
     */
    const STATUS_SUCCESS = '0000'; // 결제 성공, 그 외 오류 코드

    /**
     * order_lesson.order_status
     */
    const STATUS_PAYMENT = '00'; // 결제
    const STATUS_CANCEL  = '01'; // 취소
    const STATUS_REFUND  = '02'; // 환불

    /**
     * order_lesson.pg_req_method
     */
    const METHOD_CLESSON   = 'clesson';   // 관리자 결제
    const METHOD_FREE      = 'free';      // 무료 강의
    const METHOD_EVENT     = 'event';     // 무료 이벤트에 의한 자동 결제
    const METHOD_CARD      = 'card';      // 신용카드
    const METHOD_VBANK     = 'vbank';     // 가상계좌
    const METHOD_PARENT    = 'parent';    // 부모님 결제 요청
    const METHOD_TRANS     = 'trans';     // 계좌이체
    const METHOD_SUBSCRIBE = 'subscribe'; // 자동 결제
    const ORDER_METHODS    = [
        self::METHOD_CARD      => '신용카드 결제',
        self::METHOD_VBANK     => '가상계좌 입금',
        self::METHOD_PARENT    => '부모님결제 요청',
        self::METHOD_SUBSCRIBE => '정기 결제',
    ];

    ///////////////////////////////////////////////////////////////////////////
    //
    // Teacher income
    //
    ///////////////////////////////////////////////////////////////////////////
    const ROOME_RENTAL_FEE    = 5000;
    const SETTLE_RATE_LESSON  = 20;
    const SETTLE_RATE_GLESSON = 25;
    const SETTLE_RATE_ONEDAY  = 25; // 실제 사용 하지 않음
    const SETTLE_RATE_CLASS   = 60; // 실제 사용 하지 않음

}