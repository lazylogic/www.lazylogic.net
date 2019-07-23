<?php

namespace App\Constants;

interface RelationConstants
{
    /**
     * member_relation.status
     */
    const STATUS_REQUEST = '11'; // 요청
    const STATUS_RETRY   = '12'; // 재요청
    const STATUS_CANCEL  = '10'; // 취소
    const STATUS_ACCEPT  = '21'; // 수락
    const STATUS_REJECT  = '20'; // 거절
    const STATUS_RELEASE = '30'; // 해제
}